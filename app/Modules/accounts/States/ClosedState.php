<?php

namespace App\Modules\Accounts\States;

use App\Modules\Accounts\Models\BankAccount;

class ClosedState implements AccountState
{
    public function deposit(BankAccount $account, float $amount): BankAccount
    {
        throw new \Exception('Cannot deposit to a closed account');
    }

    public function withdraw(BankAccount $account, float $amount): BankAccount
    {
        throw new \Exception('Cannot withdraw from a closed account');
    }

    public function close(BankAccount $account): BankAccount
    {
        throw new \Exception('Account is already closed');
    }

    public function freeze(BankAccount $account): BankAccount
    {
        throw new \Exception('Cannot freeze a closed account');
    }

    public function suspend(BankAccount $account): BankAccount
    {
        throw new \Exception('Cannot suspend a closed account');
    }
}
