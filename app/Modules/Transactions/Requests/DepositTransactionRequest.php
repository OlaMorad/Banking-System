<?php

namespace App\Modules\Transactions\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepositTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'source_account_id' => 'required|exists:bank_accounts,id',
            'transaction_amount' => 'required|numeric|min:0.01',
            'transaction_currency' => 'nullable|string|size:3', // default USD
            'notes' => 'nullable|string',
            'payment_method' => 'required|string',
        ];
    }
}
