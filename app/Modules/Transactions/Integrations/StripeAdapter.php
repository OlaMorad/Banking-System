<?php

namespace App\Modules\Transactions\Integrations;

use Stripe\StripeClient;

class StripeAdapter implements PaymentGateway
{
    protected StripeClient $client;

    public function __construct()
    {
        $this->client = new StripeClient(config('services.stripe.secret'));
    }

    public function createCheckout(array $payload): array
    {
        try {
            $amountCents = (int) round($payload['amount'] * 100);

            $session = $this->client->checkout->sessions->create([
                'mode' => 'payment',
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => strtolower($payload['currency']),
                        'product_data' => [
                            'name' => $payload['description'] ?? 'Deposit',
                        ],
                        'unit_amount' => $amountCents,
                    ],
                    'quantity' => 1,
                ]],
                'metadata' => [
                    'transaction_id' => $payload['transaction_id'],
                ],
                'success_url' => config('app.url').'/deposit/success?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => config('app.url').'/deposit/cancel',

            ]);

            return [
                'status' => 'pending',
                'checkout_url' => $session->url,
                'session_id' => $session->id,
            ];
        } catch (\Throwable $e) {
            return [
                'status' => 'failed',
                'error' => $e->getMessage(),
            ];
        }
    }

    public function charge(array $payload): array
    {
        return [];
    }

    public function refund(string $chargeId, ?float $amount = null): array
    {
        return [];
    }
}
