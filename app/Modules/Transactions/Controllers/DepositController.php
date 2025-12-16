<?php

namespace App\Modules\Transactions\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function success(Request $request)
    {
        return view('deposit.success', [
            'session_id' => $request->get('session_id'),
        ]);
    }

    public function cancel()
    {
        return view('deposit.cancel');
    }
}
