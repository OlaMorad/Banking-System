<?php

namespace App\Modules\accounts\States;

use App\Modules\accounts\Models\BankAccount;

class ActiveState implements AccountState
{
    public function deposit(BankAccount $account, float $amount): BankAccount
    {
        $account->balance += $amount;
        $account->save();
        return $account;
    }

    public function withdraw(BankAccount $account, float $amount): BankAccount
    {
        if ($account->balance < $amount) {
            throw new \Exception("Insufficient balance");
        }
        $account->balance -= $amount;
        $account->save();
        return $account;
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
        $account->status = 'suspended';
        $account->save();
        $account->setState(new SuspendedState());
        return $account;
    }
}
