<?php

namespace App\Modules\Accounts\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Modules\Accounts\Services\BankAccountStateService;

class AccountStateController extends Controller
{
    protected $stateService;

    public function __construct(BankAccountStateService $stateService)
    {
        $this->stateService = $stateService;
    }

    public function deposit(int $id, float $amount)
    {
        $account = $this->stateService->deposit($id, $amount);

        return ApiResponse::sendResponse(200, 'Deposit successful', $account);
    }

    public function withdraw(int $id, float $amount)
    {
        $account = $this->stateService->withdraw($id, $amount);

        return ApiResponse::sendResponse(200, 'Withdrawal successful', $account);
    }

    public function close(int $id)
    {
        $account = $this->stateService->close($id);

        return ApiResponse::sendResponse(200, 'Account closed successfully', $account);
    }

    public function freeze(int $id)
    {
        $account = $this->stateService->freeze($id);

        return ApiResponse::sendResponse(200, 'Account frozen successfully', $account);
    }

    public function suspend(int $id)
    {
        $account = $this->stateService->suspend($id);

        return ApiResponse::sendResponse(200, 'Account suspended successfully', $account);
    }
}
