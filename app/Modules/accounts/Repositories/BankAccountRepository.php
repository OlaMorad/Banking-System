<?php

namespace App\Modules\accounts\Repositories;

use App\Modules\accounts\Models\BankAccount;

class BankAccountRepository implements BankAccountRepositoryInterface
{
    public function find(int $id): ?BankAccount
    {
        $account = BankAccount::find($id);
        if ($account) {
            $account->setStateByStatus();
        }

        return $account;
    }

    public function update(BankAccount $account, array $data): BankAccount
    {
        $account->update($data);
        $account->setStateByStatus();

        return $account;
    }
}
