<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Payment\PhonePeService;
use App\Models\PaymentTransaction;
use App\Models\ServiceChargeInvoice;
use App\Models\User;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WebhookController extends Controller
{
    protected PhonePeService $phonepe;

    public function __construct(PhonePeService $phonepe)
    {
        $this->phonepe = $phonepe;
    }

    /**
     * Handle incoming PhonePe webhook events (Server-to-Server)
     */
    public function handlePhonePe(Request $request)
    {
        $rawContent = $request->getContent();
        $signature  = $request->header('X-VERIFY') ?: $request->header('x-verify');
        $rawInput   = $request->all();

        Log::info('PhonePe Webhook Received', [
            'signature' => $signature ? 'Present' : 'Missing',
            'has_raw'   => !empty($rawContent),
        ]);

        $base64Response = $rawInput['response'] ?? null;

        // If response is nested in json body
        if (!$base64Response && !empty($rawContent)) {
            $decodedJson = json_decode($rawContent, true);
            $base64Response = $decodedJson['response'] ?? null;
        }

        if (!$base64Response) {
            Log::warning('PhonePe Webhook Missing Base64 Response Payload', $rawInput);
            return response()->json(['success' => false, 'message' => 'Missing response payload'], 400);
        }

        // Verify PhonePe signature if present
        if ($signature && !$this->phonepe->verifyWebhookSignature($base64Response, $signature)) {
            Log::warning('PhonePe Webhook Signature Verification Failed');
            return response()->json(['success' => false, 'message' => 'Invalid signature'], 400);
        }

        // Decode Base64 JSON Payload
        $decodedPayload = json_decode(base64_decode($base64Response), true);

        if (!$decodedPayload || !isset($decodedPayload['code'])) {
            Log::warning('PhonePe Webhook Failed to Decode Base64 Payload', ['payload' => $base64Response]);
            return response()->json(['success' => false, 'message' => 'Invalid JSON in base64 response'], 400);
        }

        Log::info('PhonePe Webhook Decoded Payload', ['payload' => $decodedPayload]);

        $code        = $decodedPayload['code'] ?? '';
        $data        = $decodedPayload['data'] ?? [];
        $merchantId  = $data['merchantId'] ?? '';
        $orderId     = $data['merchantTransactionId'] ?? '';
        $providerTxn = $data['transactionId'] ?? '';
        $amountInRs  = isset($data['amount']) ? ($data['amount'] / 100) : 0;
        $state       = $data['state'] ?? '';
        $paymentType = $data['paymentInstrument']['type'] ?? 'PHONEPE_ONLINE';
        $utr         = $data['paymentInstrument']['utr'] ?? ($data['paymentInstrument']['pgTransactionId'] ?? '');

        try {
            if ($code === 'PAYMENT_SUCCESS' || $state === 'COMPLETED') {
                $this->handlePhonePeSuccess($orderId, $providerTxn, $amountInRs, $paymentType, $utr, $decodedPayload);
            } else {
                $this->handlePhonePeFailed($orderId, $providerTxn, $code, $decodedPayload['message'] ?? 'Payment failed', $decodedPayload);
            }

            return response()->json([
                'success' => true,
                'message' => 'PhonePe webhook processed successfully',
            ], 200);

        } catch (\Exception $e) {
            Log::error("PhonePe Webhook Processing Error: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle successful PhonePe payment
     */
    protected function handlePhonePeSuccess(string $orderId, string $paymentId, float $amount, string $paymentType, string $utr, array $fullPayload): void
    {
        if (empty($orderId)) {
            Log::warning('PhonePe Webhook Success missing merchantTransactionId');
            return;
        }

        DB::transaction(function () use ($orderId, $paymentId, $amount, $paymentType, $utr, $fullPayload) {
            $txn = PaymentTransaction::where('order_id', $orderId)->first();

            // If already processed and marked successful
            if ($txn && $txn->status === 'success') {
                Log::info("PhonePe Webhook: Transaction #{$txn->id} already marked success.");
                return;
            }

            $candidateId = $txn?->candidate_id;
            $invoiceId   = $txn?->invoice_id;
            $type        = $txn?->type ?? 'service_charge';

            if ($txn) {
                $txn->update([
                    'payment_id'       => $paymentId,
                    'status'           => 'success',
                    'payment_method'   => strtolower($paymentType),
                    'gateway'          => 'phonepe',
                    'gateway_response' => $fullPayload,
                    'webhook_payload'  => $fullPayload,
                ]);
            } else {
                $txn = PaymentTransaction::create([
                    'candidate_id'     => $candidateId,
                    'amount'           => $amount,
                    'transaction_id'   => $orderId,
                    'order_id'         => $orderId,
                    'payment_id'       => $paymentId,
                    'type'             => $type,
                    'status'           => 'success',
                    'gateway'          => 'phonepe',
                    'payment_method'   => strtolower($paymentType),
                    'invoice_id'       => $invoiceId,
                    'gateway_response' => $fullPayload,
                    'webhook_payload'  => $fullPayload,
                ]);
            }

            // Handle Registration / Verification Fee
            if ($type === 'registration_fee' && $candidateId) {
                $user = User::with('profile')->find($candidateId);
                if ($user && $user->profile) {
                    $user->profile->update([
                        'initial_fee_paid' => true,
                        'is_fee_paid'      => true,
                        'plan_type'        => $amount >= 1000 ? 'premium' : 'standard',
                    ]);

                    NotificationHelper::notifyUser(
                        $candidateId,
                        'Registration Payment Confirmed 💳',
                        '₹' . number_format($amount, 2) . ' received via PhonePe. Your account is activated and ready for job matching.',
                        route('candidate.dashboard'),
                        'fas fa-check-circle'
                    );
                }
            }

            // Handle Service Charge Invoices
            if ($invoiceId) {
                $invoice = ServiceChargeInvoice::find($invoiceId);
                if ($invoice && $invoice->status !== 'paid') {
                    $invoice->update([
                        'status'       => 'paid',
                        'payment_date' => now(),
                    ]);

                    // Sync candidate profile pending balance
                    $user = User::with('profile')->find($candidateId);
                    if ($user && $user->profile) {
                        $user->profile->update([
                            'pending_amount' => max(0, (float)$user->profile->pending_amount - (float)$invoice->amount),
                            'is_fee_paid'    => true,
                        ]);
                    }

                    NotificationHelper::notifyUser(
                        $candidateId,
                        'Service Charge Payment Confirmed ✅',
                        '₹' . number_format($amount, 2) . ' received via PhonePe. Your payment receipt is updated in your portal.',
                        route('candidate.serviceCharge.show'),
                        'fas fa-check-circle'
                    );

                    // Email Receipt if mail configured
                    if ($user && $user->email) {
                        try {
                            Mail::to($user->email)->send(
                                new \App\Mail\ServiceChargePaymentReceiptMail($invoice, $user, $amount)
                            );
                        } catch (\Exception $e) {
                            Log::error("Webhook Receipt Email Error: " . $e->getMessage());
                        }
                    }
                }
            }

            // Notify Admin
            NotificationHelper::notifyAdmin(
                '💳 PhonePe Payment Received',
                '₹' . number_format($amount, 2) . ' received via PhonePe (' . strtoupper($paymentType) . ') for ' . ucfirst(str_replace('_', ' ', $type)) . (empty($utr) ? '' : ' [UTR: ' . $utr . ']') . '.',
                route('admin.transactions.index'),
                'fas fa-wallet'
            );
        });
    }

    /**
     * Handle failed PhonePe payment
     */
    protected function handlePhonePeFailed(string $orderId, string $paymentId, string $errorCode, string $errorDescription, array $fullPayload): void
    {
        Log::warning('PhonePe Webhook: Payment Failed', [
            'order_id'    => $orderId,
            'payment_id'  => $paymentId,
            'error_code'  => $errorCode,
            'description' => $errorDescription,
        ]);

        if ($orderId) {
            $txn = PaymentTransaction::where('order_id', $orderId)->first();
            if ($txn && $txn->status !== 'success') {
                $txn->update([
                    'status'            => 'failed',
                    'payment_id'        => $paymentId,
                    'gateway'           => 'phonepe',
                    'error_code'        => $errorCode,
                    'error_description' => $errorDescription,
                    'webhook_payload'   => $fullPayload,
                ]);
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Razorpay Webhook Handler (Commented Out as requested)
    |--------------------------------------------------------------------------
    */
    /*
    public function handleRazorpay(Request $request)
    {
        return response()->json(['message' => 'Razorpay is disabled.'], 200);
    }
    */
}
