<?php

namespace App\Modules\Transactions\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Modules\Transactions\Requests\DepositTransactionRequest;
use App\Modules\Transactions\Resources\TransactionResource;
use App\Modules\Transactions\Services\DepositTransactionService;
use Illuminate\Support\Facades\Log;

class DepositTransactionController extends Controller
{
    public function __construct(protected DepositTransactionService $service) {}

    public function deposit(DepositTransactionRequest $request)
    {
        $transaction = $this->service->deposit($request->validated() + [
            'user_id' => $request->user()->id,
        ]);

        //  Log::info('stripe response', $transaction);
        return ApiResponse::sendResponse(200, 'ok', new TransactionResource($transaction));
    }
}
