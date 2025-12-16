<?php

namespace App\Modules\Transactions\Repositories;

use App\Modules\Transactions\Models\Transaction;

interface TransactionRepositoryInterface
{
    public function create(array $data): Transaction;

    public function findByReference(string $reference): ?Transaction;

    public function save(Transaction $transaction): Transaction;
}
