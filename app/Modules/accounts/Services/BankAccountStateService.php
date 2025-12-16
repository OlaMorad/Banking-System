<?php

namespace App\Modules\accounts\Services;

use App\Modules\accounts\Composites\AccountComponent;
use App\Modules\accounts\Composites\AccountGroup;
use App\Modules\accounts\Composites\SingleAccount;
use App\Modules\accounts\Models\BankAccount;
use App\Modules\accounts\Repositories\BankAccountRepositoryInterface;

class BankAccountStateService
{
    protected BankAccountRepositoryInterface $repo;

    public function __construct(BankAccountRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    /**
     * جلب الـ Component المناسب سواء Single أو Composite
     */
    protected function getAccountComponent(int $id): AccountComponent
    {
        $account = $this->repo->find($id);

        if (! $account) {
            throw new \Exception('Account not found');
        }

        // إذا له أبناء => Composite
        if ($account->children()->exists()) {
            return new AccountGroup($account);
        }

        // حساب فردي
        return new SingleAccount($account);
    }

    public function deposit(int $id, float $amount): BankAccount
    {
        $component = $this->getAccountComponent($id);
        $component->deposit($amount);

        return $component->getModel();
    }

    public function withdraw(int $id, float $amount): BankAccount
    {
        $component = $this->getAccountComponent($id);
        $component->withdraw($amount);

        return $component->getModel();
    }

    public function close(int $id): BankAccount
    {
        $component = $this->getAccountComponent($id);
        $component->close();

        return $component->getModel();
    }

    public function freeze(int $id): BankAccount
    {
        $component = $this->getAccountComponent($id);
        $component->freeze();

        return $component->getModel();
    }

    public function suspend(int $id): BankAccount
    {
        $component = $this->getAccountComponent($id);
        $component->suspend();

        return $component->getModel();
    }
}
