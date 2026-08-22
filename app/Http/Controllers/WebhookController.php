<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Payment\RazorpayService;
use App\Models\PaymentTransaction;
use App\Models\ServiceChargeInvoice;
use App\Models\User;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WebhookController extends Controller
{
    protected RazorpayService $razorpay;

    public function __construct(RazorpayService $razorpay)
    {
        $this->razorpay = $razorpay;
    }

    /**
     * Handle incoming Razorpay webhook events
     */
    public function handleRazorpay(Request $request)
    {
        $payload   = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');

        Log::info('Razorpay Webhook Received', [
            'event'     => $request->input('event'),
            'signature' => $signature ? 'Present' : 'Missing',
        ]);

        // Verify Webhook Signature if webhook secret is configured
        if (config('services.razorpay.webhook_secret')) {
            if (!$signature || !$this->razorpay->verifyWebhookSignature($payload, $signature)) {
                Log::warning('Razorpay Webhook Signature Verification Failed');
                return response()->json(['error' => 'Invalid webhook signature'], 400);
            }
        }

        $event = json_decode($payload, true);
        if (!$event || !isset($event['event'])) {
            return response()->json(['error' => 'Invalid webhook payload'], 400);
        }

        $eventType = $event['event'];
        $entity    = $event['payload']['payment']['entity'] ?? ($event['payload']['order']['entity'] ?? []);

        try {
            switch ($eventType) {
                case 'payment.captured':
                case 'order.paid':
                    $this->handlePaymentSuccess($entity, $event);
                    break;

                case 'payment.failed':
                    $this->handlePaymentFailed($entity, $event);
                    break;

                default:
                    Log::info("Razorpay unhandled webhook event: {$eventType}");
                    break;
            }

            return response()->json(['status' => 'success', 'event' => $eventType], 200);
        } catch (\Exception $e) {
            Log::error("Razorpay Webhook Processing Error [{$eventType}]: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle successful payment event
     */
    protected function handlePaymentSuccess(array $paymentEntity, array $fullEvent): void
    {
        $orderId   = $paymentEntity['order_id'] ?? null;
        $paymentId = $paymentEntity['id'] ?? null;
        $amount    = isset($paymentEntity['amount']) ? ($paymentEntity['amount'] / 100) : 0;
        $method    = $paymentEntity['method'] ?? 'online';
        $notes     = $paymentEntity['notes'] ?? [];

        if (!$orderId && !$paymentId) {
            Log::warning('Webhook payment success missing order_id/payment_id');
            return;
        }

        DB::transaction(function () use ($orderId, $paymentId, $amount, $method, $notes, $paymentEntity, $fullEvent) {
            // Find existing transaction by order_id or payment_id
            $txn = null;
            if ($orderId) {
                $txn = PaymentTransaction::where('order_id', $orderId)->first();
            }
            if (!$txn && $paymentId) {
                $txn = PaymentTransaction::where('payment_id', $paymentId)->first();
            }

            // If already processed and successful, don't duplicate
            if ($txn && $txn->status === 'success') {
                Log::info("Webhook: Transaction #{$txn->id} already marked success.");
                return;
            }

            $candidateId = $notes['user_id'] ?? ($notes['candidate_id'] ?? ($txn?->candidate_id ?? null));
            $invoiceId   = $notes['invoice_id'] ?? ($txn?->invoice_id ?? null);
            $type        = $notes['type'] ?? ($txn?->type ?? 'service_charge');

            if ($txn) {
                $txn->update([
                    'payment_id'       => $paymentId,
                    'status'           => 'success',
                    'payment_method'   => $method,
                    'gateway'          => 'razorpay',
                    'gateway_response' => $paymentEntity,
                    'webhook_payload'  => $fullEvent,
                ]);
            } else {
                $txn = PaymentTransaction::create([
                    'candidate_id'     => $candidateId,
                    'amount'           => $amount,
                    'transaction_id'   => 'RZP_' . ($paymentId ?: time()),
                    'order_id'         => $orderId,
                    'payment_id'       => $paymentId,
                    'type'             => $type,
                    'status'           => 'success',
                    'gateway'          => 'razorpay',
                    'payment_method'   => $method,
                    'invoice_id'       => $invoiceId,
                    'gateway_response' => $paymentEntity,
                    'webhook_payload'  => $fullEvent,
                ]);
            }

            // Update ServiceChargeInvoice if present
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

                    // In-app notification to candidate
                    NotificationHelper::notifyUser(
                        $candidateId,
                        'Service Charge Payment Confirmed ✅',
                        '₹' . number_format($amount, 2) . ' received via Razorpay. Your payment receipt is updated in your portal.',
                        route('candidate.serviceCharge.show'),
                        'fas fa-check-circle'
                    );

                    // Email Receipt
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
                '💳 Razorpay Payment Received',
                '₹' . number_format($amount, 2) . ' received via Razorpay (' . strtoupper($method) . ') for ' . ucfirst(str_replace('_', ' ', $type)) . '.',
                route('admin.transactions.index'),
                'fas fa-wallet'
            );
        });
    }

    /**
     * Handle failed payment event
     */
    protected function handlePaymentFailed(array $paymentEntity, array $fullEvent): void
    {
        $orderId          = $paymentEntity['order_id'] ?? null;
        $paymentId        = $paymentEntity['id'] ?? null;
        $errorCode        = $paymentEntity['error_code'] ?? 'PAYMENT_FAILED';
        $errorDescription = $paymentEntity['error_description'] ?? 'Payment attempt failed';

        Log::warning('Webhook: Payment Failed', [
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
                    'error_code'        => $errorCode,
                    'error_description' => $errorDescription,
                    'webhook_payload'   => $fullEvent,
                ]);
            }
        }
    }
}
