<?php

namespace App\Modules\Transactions\Handlers;

use App\Modules\Transactions\Models\Transaction;

class ManagerHandler implements TransactionHandler
{
    protected ?TransactionHandler $next = null;

    public function setNext(TransactionHandler $handler): TransactionHandler
    {
        $this->next = $handler;

        return $handler;
    }

    public function handle(Transaction $transaction): Transaction
    {
        $manager = auth()->user();

        if ($transaction->transaction_amount <= 10000) {
            if (! $manager->hasRole('Manager')) {
                throw new \Exception('Only Manager can approve this transaction');
            }
            return $transaction->approveBy($manager->id);
        }

        if ($this->next) {
            return $this->next->handle($transaction);
        }

        throw new \Exception('Transaction requires Admin approval');
    }
}
