<?php

namespace App\Modules\accounts\Composites;

interface AccountComponent
{
    public function getBalance(): float;

    public function deposit(float $amount): void;

    public function withdraw(float $amount): void;

    public function close(): void;

    public function freeze(): void;

    public function suspend(): void;

    public function addChild(AccountComponent $account): void;

    public function removeChild(AccountComponent $account): void;

    public function getChildren(): array;

    public function getModel(): \App\Modules\Accounts\Models\BankAccount;
}
