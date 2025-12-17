<?php

namespace App\Modules\Transactions\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Modules\Transactions\Models\Transaction;
use App\Modules\Transactions\Services\TransactionApprovalService;
use Illuminate\Http\Request;
use App\Modules\Transactions\Enums\TransactionStatus;

class TransactionController extends Controller
{
    protected TransactionApprovalService $approvalService;

    public function __construct(TransactionApprovalService $approvalService)
    {
        $this->approvalService = $approvalService;
    }

    public function approveTransaction(Request $request, int $id)
    {
        $transaction = Transaction::find($id);
        if (! $transaction) {
            return ApiResponse::sendError('Transaction not found', 404);
        }
        if ($transaction->transaction_status == TransactionStatus::APPROVED) {
            return ApiResponse::sendError('this transaction already approved');
        }
        $approvedTransaction = $this->approvalService->approve($transaction);

        return ApiResponse::sendResponse(
            200,
            "Transaction approved by {$approvedTransaction->approved_by_user_id}",
            $approvedTransaction
        );
    }
}
