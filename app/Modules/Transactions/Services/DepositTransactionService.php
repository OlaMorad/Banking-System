<?php

namespace App\Modules\Transactions\Services;

use App\Modules\Transactions\Enums\TransactionStatus;
use App\Modules\Transactions\Enums\TransactionType;
use App\Modules\Transactions\Integrations\PaymentGateway;
use App\Modules\Transactions\Repositories\TransactionRepositoryInterface;
use Illuminate\Support\Str;

class DepositTransactionService
{
    public function __construct(
        protected TransactionRepositoryInterface $repository,
        protected PaymentGateway $paymentGateway) {}

    public function deposit(array $data)
    {
        $transaction = $this->repository->create([
            'transaction_reference' => Str::uuid(),
            'source_account_id' => $data['source_account_id'],
            'transaction_type' => TransactionType::DEPOSIT,
          //  'transaction_status' => TransactionStatus::PENDING,
            'transaction_amount' => $data['transaction_amount'],
            'transaction_currency' => $data['transaction_currency'] ?? 'USD',
            'notes' => $data['notes'] ?? null,
            'metadata' => $data['metadata'] ?? [],
            'created_by_user_id' => $data['user_id'] ?? null,
        ]);

        $chargeResult = $this->paymentGateway->charge([
            'amount' => $transaction->transaction_amount,
            'currency' => $transaction->transaction_currency,
            'payment_method_types' => ['card'],
            'payment_method' => $data['payment_method'],
            'description' => 'Deposit #' . $transaction->transaction_reference,
            'metadata' => ['transaction_id' => $transaction->id],
            'idempotency_key' => $transaction->transaction_reference,
        ]);

        $transaction->transaction_status = $chargeResult['status'] === 'succeeded'
            ? TransactionStatus::COMPLETED
            : TransactionStatus::FAILED;

        $transaction->metadata = $chargeResult['raw'];
        $this->repository->save($transaction);

        return $transaction;
    }
}
