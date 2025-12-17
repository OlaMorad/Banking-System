<?php

namespace App\Modules\Transactions\Handlers;

use App\Modules\Transactions\Models\Transaction;

class AdminHandler implements TransactionHandler
{
    protected ?TransactionHandler $next = null;

    public function setNext(TransactionHandler $handler): TransactionHandler
    {
        $this->next = $handler;

        return $handler;
    }

    public function handle(Transaction $transaction): Transaction
    {
        $admin = auth()->user();
        // dd($admin);
        if (! $admin->hasRole('Admin')) {
            throw new \Exception('Only Admin can approve this transaction');
        }
        return $transaction->approveBy($admin->id);
    }
}
