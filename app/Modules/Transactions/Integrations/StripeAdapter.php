<?php

namespace App\Modules\Transactions\Integrations;

use Stripe\StripeClient;

class StripeAdapter implements PaymentGateway
{
    protected StripeClient $client;

    public function __construct()
    {
        $this->client = new StripeClient(config('services.stripe.secret', env('STRIPE_SECRET')));
    }

    public function charge(array $payload): array
    {
        $amountCents = (int) round(($payload['amount'] * 100));
        $currency = strtolower($payload['currency'] ?? 'USD');

        try {
            $params = [
                'amount' => $amountCents,
                'currency' => $currency,
                'confirm' => true,
                'confirmation_method' => 'automatic',
                'description' => $payload['description'] ?? null,
                'metadata' => $payload['metadata'] ?? [],
            ];

            if (!empty($payload['payment_method'])) {
                $params['payment_method'] = $payload['payment_method'];
            }

            $options = [];
            if (!empty($payload['idempotency_key'])) {
                $options['idempotency_key'] = $payload['idempotency_key'];
            }

            $pi = $this->client->paymentIntents->create($params, $options);

            $status = $pi->status === 'succeeded' ? 'succeeded' : $pi->status;

            return [
                'id' => $pi->id,
                'status' => $status,
                'raw' => $pi->toArray(),
            ];
        } catch (\Throwable $e) {
            return [
                'id' => null,
                'status' => 'failed',
                'raw' => ['error' => $e->getMessage()],
            ];
        }
    }

    public function refund(string $chargeId, ?float $amount = null): array
    {
        try {
            $params = ['payment_intent' => $chargeId];
            if ($amount !== null) {
                $params['amount'] = (int) round($amount * 100);
            }

            $refund = $this->client->refunds->create($params);

            return [
                'id' => $refund->id,
                'status' => $refund->status,
                'raw' => $refund->toArray(),
            ];
        } catch (\Throwable $e) {
            return [
                'id' => null,
                'status' => 'failed',
                'raw' => ['error' => $e->getMessage()],
            ];
        }
    }
}
