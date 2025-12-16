<?php

namespace App\Modules\accounts\States;

use App\Modules\accounts\Models\BankAccount;

interface AccountState
{
    public function deposit(BankAccount $account, float $amount): BankAccount;

    public function withdraw(BankAccount $account, float $amount): BankAccount;

    public function close(BankAccount $account): BankAccount;

    public function freeze(BankAccount $account): BankAccount;

    public function suspend(BankAccount $account): BankAccount;
}
