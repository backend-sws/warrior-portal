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
     * Handle incoming PhonePe V2 webhook events (Server-to-Server)
     *
     * V2 sends plain JSON body (not base64 encoded)
     * Signature: x-phonepe-checksum-signature header with HMAC SHA256
     */
    public function handlePhonePe(Request $request)
    {
        $rawContent = $request->getContent();
        $signature  = $request->header('x-phonepe-checksum-signature')
                   ?: $request->header('X-PHONEPE-CHECKSUM-SIGNATURE')
                   ?: $request->header('X-VERIFY')       // fallback for older format
                   ?: $request->header('x-verify');
        $rawInput   = $request->all();

        Log::info('PhonePe V2 Webhook Received', [
            'signature' => $signature ? 'Present' : 'Missing',
            'has_raw'   => !empty($rawContent),
        ]);

        // V2 sends direct JSON payload (no base64 encoding)
        $payload = $rawInput;

        // If payload is empty, try decoding raw content
        if (empty($payload) && !empty($rawContent)) {
            $payload = json_decode($rawContent, true);
        }

        if (empty($payload)) {
            Log::warning('PhonePe V2 Webhook Missing Payload', ['raw' => $rawContent]);
            return response()->json(['success' => false, 'message' => 'Missing payload'], 400);
        }

        // Verify HMAC signature if present
        if ($signature && !$this->phonepe->verifyWebhookSignature($rawContent, $signature)) {
            Log::warning('PhonePe V2 Webhook Signature Verification Failed');
            return response()->json(['success' => false, 'message' => 'Invalid signature'], 400);
        }

        Log::info('PhonePe V2 Webhook Decoded Payload', ['payload' => $payload]);

        // V2 payload structure
        $type        = $payload['type'] ?? 'PG_ORDER_COMPLETED';
        $data        = $payload['payload'] ?? $payload['data'] ?? $payload;
        $orderId     = $data['merchantOrderId'] ?? $data['merchantTransactionId'] ?? '';
        $providerTxn = $data['orderId'] ?? $data['transactionId'] ?? '';
        $state       = $data['state'] ?? '';
        $amountInRs  = isset($data['amount']) ? ($data['amount'] / 100) : 0;

        // Extract payment method from paymentDetails
        $paymentType = 'PHONEPE_ONLINE';
        $utr         = '';
        $paymentDetails = $data['paymentDetails'] ?? [];
        if (!empty($paymentDetails) && is_array($paymentDetails)) {
            $latestPayment = end($paymentDetails);
            $paymentType   = $latestPayment['paymentMode'] ?? ($latestPayment['rail']['type'] ?? 'PHONEPE_ONLINE');
            $utr           = $latestPayment['rail']['utr'] ?? ($latestPayment['rail']['pgTransactionId'] ?? '');
        }

        try {
            if ($state === 'COMPLETED' || ($payload['code'] ?? '') === 'PAYMENT_SUCCESS') {
                $this->handlePhonePeSuccess($orderId, $providerTxn, $amountInRs, $paymentType, $utr, $payload);
            } else {
                $errorMsg = $data['errorContext']['description'] ?? ($payload['message'] ?? 'Payment failed');
                $this->handlePhonePeFailed($orderId, $providerTxn, $state, $errorMsg, $payload);
            }

            return response()->json([
                'success' => true,
                'message' => 'PhonePe V2 webhook processed successfully',
            ], 200);

        } catch (\Exception $e) {
            Log::error("PhonePe V2 Webhook Processing Error: " . $e->getMessage() . "\n" . $e->getTraceAsString());
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
