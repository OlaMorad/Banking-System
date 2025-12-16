<?php

namespace App\Modules\accounts\Composites;

use App\Modules\accounts\Models\BankAccount;

class SingleAccount implements AccountComponent
{
    protected BankAccount $account;

    public function __construct(BankAccount $account)
    {
        $this->account = $account;
    }

    public function deposit(float $amount): void
    {
        $this->account->getState()->deposit($this->account, $amount);
    }

    public function withdraw(float $amount): void
    {
        $this->account->getState()->withdraw($this->account, $amount);
    }

    public function close(): void
    {
        $this->account->getState()->close($this->account);
    }

    public function freeze(): void
    {
        $this->account->getState()->freeze($this->account);
    }

    public function suspend(): void
    {
        $this->account->getState()->suspend($this->account);
    }

    public function getBalance(): float
    {
        return $this->account->balance;
    }

    public function addChild(AccountComponent $account): void
    {
        throw new \Exception('Cannot add child to a single account');
    }

    public function removeChild(AccountComponent $account): void
    {
        throw new \Exception('Cannot remove child from a single account');
    }

    public function getChildren(): array
    {
        return [];
    }

    public function getModel(): BankAccount
    {
        return $this->account;
    }
}
