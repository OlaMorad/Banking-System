<?php

namespace App\Modules\accounts\Composites;

use App\Modules\accounts\Models\BankAccount;

class AccountGroup implements AccountComponent
{
    protected BankAccount $account;

    protected array $children = [];

    public function __construct(BankAccount $account)
    {
        $this->account = $account;

        foreach ($account->children as $child) {
            $this->children[] = new SingleAccount($child);
        }
    }

    public function deposit(float $amount): void
    {
        $this->account->getState()->deposit($this->account, $amount);

        foreach ($this->children as $child) {
            $child->deposit($amount);
        }
    }

    public function withdraw(float $amount): void
    {
        $this->account->getState()->withdraw($this->account, $amount);

        foreach ($this->children as $child) {
            $child->withdraw($amount);
        }
    }

    public function close(): void
    {
        $this->account->getState()->close($this->account);

        foreach ($this->children as $child) {
            $child->close();
        }
    }

    public function freeze(): void
    {
        $this->account->getState()->freeze($this->account);

        foreach ($this->children as $child) {
            $child->freeze();
        }
    }

    public function suspend(): void
    {
        $this->account->getState()->suspend($this->account);

        foreach ($this->children as $child) {
            $child->suspend();
        }
    }

    public function getBalance(): float
    {
        $total = $this->account->balance;
        foreach ($this->children as $child) {
            $total += $child->getBalance();
        }

        return $total;
    }

    public function addChild(AccountComponent $account): void
    {
        $this->children[] = $account;
    }

    public function removeChild(AccountComponent $account): void
    {
        $this->children = array_filter($this->children, fn ($c) => $c !== $account);
    }

    public function getChildren(): array
    {
        return $this->children;
    }

    public function getModel(): BankAccount
    {
        return $this->account;
    }
}
