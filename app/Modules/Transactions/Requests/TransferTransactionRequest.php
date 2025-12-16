<?php

namespace App\Modules\Transactions\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'source_account_id' => 'required|exists:bank_accounts,id',
            'destination_account_id' => 'required|exists:bank_accounts,id|different:source_account_id',
            'transaction_amount' => 'required|numeric|min:0.01',
            'transaction_currency' => 'nullable|string|size:3',
            'notes' => 'nullable|string|max:255',
        ];
    }
}
