<?php

namespace App\Modules\Transactions\Integrations;

interface PaymentGateway
{
    public function createCheckout(array $payload): array;

    public function charge(array $payload): array;

    public function refund(string $chargeId, ?float $amount = null): array;
}
