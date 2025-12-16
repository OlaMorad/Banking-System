<?php

namespace App\Modules\Transactions\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Modules\Transactions\Requests\TransferTransactionRequest;
use App\Modules\Transactions\Services\TransferTransactionService;
use App\Modules\Transactions\Resources\TransactionResource;

class TransferTransactionController extends Controller
{
    public function __construct(
        protected TransferTransactionService $service
    ) {}

    public function transfer(TransferTransactionRequest $request)
    {
        $transaction = $this->service->transfer(
            $request->validated() + [
                'user_id' => $request->user()->id
            ]
        );

        return ApiResponse::sendResponse(200,'Transfer processed successfully.',new TransactionResource($transaction));
    }
}
