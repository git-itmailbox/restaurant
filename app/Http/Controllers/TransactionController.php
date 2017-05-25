<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;


class TransactionController extends Controller
{
    //

    /**
     *
     *
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function income(Request $request)
    {
        $tr = new Transaction();
        $tr->transaction_num = $request->input('transaction');
        $tr->summ_btc = $request->input('amount');
        $tr->confirmed = $request->input('confirmed');

        $order= \App\Order::where('address', $request->input('address'))->first();
        if(!$order)
            return response()->json(["status" => "error", "message"=>"address not found"]);

        $tr->order_id = $order->id;
        $tr->save();
        if($tr->id > 0){
            $order->paid_btc += $tr->summ_btc;
            $order->paid_uah += $tr->summ_btc / Config::get('fees.factor') * $order->rate * 100;
            $order->save();
        }
        if($order->paid_uah >= $order->summ_uah)
        {
            $data=[];
            $data['id']='1';
//            $data['paid_btc']=$order->paid_btc;
//            $data['paid_uah']=$order->paid_uah;
        }
        $data['id']=$order->id;
        $pusher = App::make('pusher');
        $pusher->trigger( 'test-channel','income', $data);

        return response()->json(["1"], 201);


    }
}
