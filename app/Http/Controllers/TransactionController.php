<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //
    public function income(Request $request)
    {
        $tr = new Transaction();
        $tr->transaction_num = $request->input('transaction');
        $tr->summ_btc = $request->input('amount');

        $order= \App\Order::where('address', $request->input('address'))->first();
        $tr->order_id = $order->id;

        return response()->json(['transaction'=> $tr], 201);
    }
}
