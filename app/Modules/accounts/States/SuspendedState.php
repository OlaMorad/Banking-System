<?php

namespace App\Modules\Accounts\States;

use App\Modules\Accounts\Models\BankAccount;

class SuspendedState implements AccountState
{
    public function deposit(BankAccount $account, float $amount): BankAccount
    {
        throw new \Exception("Cannot deposit to a suspended account");
    }

    public function withdraw(BankAccount $account, float $amount): BankAccount
    {
        throw new \Exception("Cannot withdraw from a suspended account");
    }

    public function close(BankAccount $account): BankAccount
    {
        $account->status = 'closed';
        $account->closed_at = now();
        $account->save();
        $account->setState(new ClosedState());
        return $account;
    }

    public function freeze(BankAccount $account): BankAccount
    {
        $account->status = 'frozen';
        $account->save();
        $account->setState(new FrozenState());
        return $account;
    }

    public function suspend(BankAccount $account): BankAccount
    {
        throw new \Exception("Account is already suspended");
    }
}
