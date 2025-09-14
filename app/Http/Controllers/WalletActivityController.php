<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WalletActivityController extends Controller
{
    public function index(Request $request)
    {
        Log::debug($request->all());
        if ($request->confirmed) {
            foreach ($request->txs as $tx) {
                $hash = $tx['hash'];

                $payment = Payment::where('transaction_hash', $hash)->first();
                if ($payment) {
                    $payment->setSuccess();
                }
            }
        }

        return response()->json([
            'status' => 'success',
        ]);
    }
}
