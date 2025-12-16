<?php

use App\Modules\Transactions\Controllers\DepositController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/deposit/success', [DepositController::class, 'success'])->name('deposit.success');
Route::get('/deposit/cancel', [DepositController::class, 'cancel'])->name('deposit.cancel');
