<?php

namespace App\Contracts;

interface PaymentGatewayInterface
{
    /**
     * Get the gateway identifier name (e.g., 'razorpay', 'phonepe', 'cashfree').
     */
    public function getGatewayName(): string;

    /**
     * Create an order on the payment gateway.
     *
     * @param array $params Must contain 'amount', 'receipt', 'notes', optional 'currency'
     * @return array ['success' => bool, 'order_id' => string, 'amount' => float, 'currency' => string, 'key' => string, 'error' => ?string, 'raw' => array]
     */
    public function createOrder(array $params): array;

    /**
     * Verify payment signature/status returned from frontend checkout or callback.
     *
     * @param array $params Contains 'order_id', 'payment_id', 'signature'
     * @return array ['success' => bool, 'payment_id' => string, 'order_id' => string, 'status' => string, 'payment_method' => ?string, 'raw' => array, 'error' => ?string]
     */
    public function verifyPayment(array $params): array;

    /**
     * Fetch complete payment details by payment ID.
     *
     * @param string $paymentId
     * @return array
     */
    public function fetchPayment(string $paymentId): array;

    /**
     * Verify webhook signature.
     *
     * @param string $payload Raw JSON request body
     * @param string $signature Signature from header (e.g., X-Razorpay-Signature)
     * @return bool
     */
    public function verifyWebhookSignature(string $payload, string $signature): bool;
}
