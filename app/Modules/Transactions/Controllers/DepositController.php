<?php

namespace App\Modules\Transactions\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepositController extends Controller
{
    public function success(Request $request)
    {
        return view('deposit.success', [
            'session_id' => $request->get('session_id')
        ]);
    }

    public function cancel()
    {
        return view('deposit.cancel');
    }
}
