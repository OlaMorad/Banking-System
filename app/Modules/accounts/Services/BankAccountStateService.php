<?php

namespace App\Modules\accounts\Services;

use App\Modules\accounts\Repositories\BankAccountRepositoryInterface;
use App\Modules\accounts\Models\BankAccount;

class BankAccountStateService
{
    protected $repo;

    public function __construct(BankAccountRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function deposit(int $id, float $amount): BankAccount
    {
        $account = $this->repo->find($id);
        if (!$account) throw new \Exception("Account not found");
        return $account->deposit($amount);
    }

    public function withdraw(int $id, float $amount): BankAccount
    {
        $account = $this->repo->find($id);
        if (!$account) throw new \Exception("Account not found");
        return $account->withdraw($amount);
    }

    public function close(int $id): BankAccount
    {
        $account = $this->repo->find($id);
        if (!$account) throw new \Exception("Account not found");
        return $account->close();
    }

    public function freeze(int $id): BankAccount
    {
        $account = $this->repo->find($id);
        if (!$account) throw new \Exception("Account not found");
        return $account->freeze();
    }

    public function suspend(int $id): BankAccount
    {
        $account = $this->repo->find($id);
        if (!$account) throw new \Exception("Account not found");
        return $account->suspend();
    }
}
