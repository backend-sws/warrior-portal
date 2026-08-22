<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use InvalidArgumentException;

class PaymentGatewayManager
{
    /**
     * The array of resolved gateway instances.
     */
    protected array $gateways = [];

    /**
     * Get a payment gateway instance.
     *
     * @param string|null $driver
     * @return PaymentGatewayInterface
     */
    public function driver(?string $driver = null): PaymentGatewayInterface
    {
        $driver = $driver ?: $this->getDefaultDriver();

        if (!isset($this->gateways[$driver])) {
            $this->gateways[$driver] = $this->createDriver($driver);
        }

        return $this->gateways[$driver];
    }

    /**
     * Create a new driver instance.
     *
     * @param string $driver
     * @return PaymentGatewayInterface
     */
    protected function createDriver(string $driver): PaymentGatewayInterface
    {
        return match ($driver) {
            'razorpay' => new RazorpayService(),
            default    => throw new InvalidArgumentException("Payment gateway driver [{$driver}] is not supported."),
        };
    }

    /**
     * Get the default gateway driver name.
     *
     * @return string
     */
    public function getDefaultDriver(): string
    {
        return env('PAYMENT_GATEWAY', 'razorpay');
    }

    /**
     * Dynamically call methods on the default driver.
     */
    public function __call(string $method, array $parameters)
    {
        return $this->driver()->$method(...$parameters);
    }
}
