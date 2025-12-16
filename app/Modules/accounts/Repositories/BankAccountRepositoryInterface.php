<?php

namespace App\Modules\accounts\Repositories;

use App\Modules\accounts\Models\BankAccount;

interface BankAccountRepositoryInterface
{
    public function find(int $id): ?BankAccount;

    public function update(BankAccount $account, array $data): BankAccount;
}
