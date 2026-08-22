<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RazorpayService implements PaymentGatewayInterface
{
    protected string $keyId;
    protected string $keySecret;
    protected string $webhookSecret;
    protected string $currency;
    protected string $merchantName;
    protected string $baseUrl = 'https://api.razorpay.com/v1';

    public function __construct()
    {
        $this->keyId         = config('services.razorpay.key_id', env('RAZORPAY_KEY_ID', ''));
        $this->keySecret     = config('services.razorpay.key_secret', env('RAZORPAY_KEY_SECRET', ''));
        $this->webhookSecret = config('services.razorpay.webhook_secret', env('RAZORPAY_WEBHOOK_SECRET', ''));
        $this->currency      = config('services.razorpay.currency', env('RAZORPAY_CURRENCY', 'INR'));
        $this->merchantName  = config('services.razorpay.merchant_name', env('RAZORPAY_MERCHANT_NAME', 'Warriors Educare'));
    }

    public function getGatewayName(): string
    {
        return 'razorpay';
    }

    public function getKeyId(): string
    {
        return $this->keyId;
    }

    public function getMerchantName(): string
    {
        return $this->merchantName;
    }

    /**
     * Create an Order on Razorpay
     */
    public function createOrder(array $params): array
    {
        $amountInRupees = (float) ($params['amount'] ?? 0);
        $amountInPaisa  = (int) round($amountInRupees * 100);
        $receipt        = $params['receipt'] ?? ('RCPT_' . time());
        $currency       = $params['currency'] ?? $this->currency;
        $notes          = $params['notes'] ?? [];

        if ($amountInPaisa <= 0) {
            return [
                'success' => false,
                'error'   => 'Invalid amount for order creation.',
                'order_id' => null,
            ];
        }

        try {
            $response = Http::withBasicAuth($this->keyId, $this->keySecret)
                ->timeout(20)
                ->post("{$this->baseUrl}/orders", [
                    'amount'   => $amountInPaisa,
                    'currency' => $currency,
                    'receipt'  => (string) $receipt,
                    'notes'    => $notes,
                    'payment'  => [
                        'capture' => 'automatic',
                        'capture_options' => [
                            'automatic_expiry_period' => 12,
                            'manual_expiry_period'    => 7200,
                            'refund_speed'            => 'optimum',
                        ]
                    ]
                ]);

            if ($response->successful()) {
                $orderData = $response->json();
                Log::info('Razorpay Order Created', [
                    'order_id' => $orderData['id'],
                    'amount'   => $amountInRupees,
                    'receipt'  => $receipt,
                ]);

                return [
                    'success'  => true,
                    'order_id' => $orderData['id'],
                    'amount'   => $amountInRupees,
                    'amount_paisa' => $amountInPaisa,
                    'currency' => $currency,
                    'key'      => $this->keyId,
                    'name'     => $this->merchantName,
                    'raw'      => $orderData,
                    'error'    => null,
                ];
            }

            $errorBody = $response->json();
            $errorMsg  = $errorBody['error']['description'] ?? 'Failed to create order on Razorpay.';
            Log::error('Razorpay Order Creation Failed', [
                'status'   => $response->status(),
                'response' => $errorBody,
            ]);

            return [
                'success'  => false,
                'order_id' => null,
                'error'    => $errorMsg,
                'raw'      => $errorBody,
            ];
        } catch (\Exception $e) {
            Log::error('Razorpay Order Exception: ' . $e->getMessage());
            return [
                'success'  => false,
                'order_id' => null,
                'error'    => 'Payment gateway connection error: ' . $e->getMessage(),
                'raw'      => [],
            ];
        }
    }

    /**
     * Verify payment signature returned from Checkout JS
     */
    public function verifyPayment(array $params): array
    {
        $orderId   = $params['order_id'] ?? $params['razorpay_order_id'] ?? '';
        $paymentId = $params['payment_id'] ?? $params['razorpay_payment_id'] ?? '';
        $signature = $params['signature'] ?? $params['razorpay_signature'] ?? '';

        if (empty($orderId) || empty($paymentId) || empty($signature)) {
            return [
                'success'    => false,
                'error'      => 'Missing required payment verification parameters (order_id, payment_id, signature).',
                'order_id'   => $orderId,
                'payment_id' => $paymentId,
            ];
        }

        // Calculate expected HMAC SHA256 signature
        $generatedSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, $this->keySecret);

        if (!hash_equals($generatedSignature, $signature)) {
            Log::warning('Razorpay Signature Verification Failed', [
                'order_id'   => $orderId,
                'payment_id' => $paymentId,
            ]);

            return [
                'success'    => false,
                'error'      => 'Invalid payment signature. Transaction could not be verified.',
                'order_id'   => $orderId,
                'payment_id' => $paymentId,
            ];
        }

        // Fetch payment details to ensure it is captured/authorized
        $paymentDetails = $this->fetchPayment($paymentId);
        $status         = $paymentDetails['status'] ?? 'unknown';
        $method         = $paymentDetails['method'] ?? null;
        $isSuccess      = in_array($status, ['captured', 'authorized']);

        Log::info('Razorpay Payment Verification Success', [
            'order_id'       => $orderId,
            'payment_id'     => $paymentId,
            'status'         => $status,
            'payment_method' => $method,
        ]);

        return [
            'success'        => $isSuccess,
            'order_id'       => $orderId,
            'payment_id'     => $paymentId,
            'status'         => $status,
            'payment_method' => $method,
            'raw'            => $paymentDetails,
            'error'          => $isSuccess ? null : "Payment status is {$status}",
        ];
    }

    /**
     * Fetch complete payment details from Razorpay API
     */
    public function fetchPayment(string $paymentId): array
    {
        try {
            $response = Http::withBasicAuth($this->keyId, $this->keySecret)
                ->timeout(15)
                ->get("{$this->baseUrl}/payments/{$paymentId}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Razorpay Fetch Payment Failed', [
                'payment_id' => $paymentId,
                'status'     => $response->status(),
                'response'   => $response->json(),
            ]);

            return ['status' => 'failed', 'error' => $response->body()];
        } catch (\Exception $e) {
            Log::error("Razorpay Fetch Payment Exception ({$paymentId}): " . $e->getMessage());
            return ['status' => 'error', 'error' => $e->getMessage()];
        }
    }

    /**
     * Verify Webhook Signature
     */
    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        if (empty($this->webhookSecret) || empty($signature)) {
            Log::warning('Razorpay Webhook Secret or Signature is missing.');
            return false;
        }

        $expectedSignature = hash_hmac('sha256', $payload, $this->webhookSecret);
        return hash_equals($expectedSignature, $signature);
    }
}
