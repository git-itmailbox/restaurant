<?php

namespace App\Http\Controllers;

use App\FstxApi;
use App\Order;
use Illuminate\Http\Request;
use App\Helpers\RatesContract;

use Illuminate\Support\Facades\Config;
use Milon\Barcode\DNS2D;

class MainController extends Controller
{
    //
    public function saveOrder(Request $request, RatesContract $rates)
    {
        $this->validate($request, [
            'summ_uah' => 'required | numeric'
        ]);

        $btcUahRate = $rates->getBtcUahRate();
        $summBtc = $request->summ_uah / $btcUahRate;
        $summBtc = ceil($summBtc * Config::get('fees.factor'));

        $order = new Order();
        $order->summ_uah = $request->summ_uah * 100;
        $order->summ_btc = $summBtc;
        $order->description = $request->description;
        $order->order_number = $request->order_number;
        $order->address = $this->getAddress();
        $order->rate = $btcUahRate;

        $order->save();
        if($order->order_number == null){
            $order->order_number = "A".$order->id;
            $order->save();
        }

        return redirect()->action(
            'MainController@payInfo', ['id' => $order->id]
        );
    }

    public function getAddress()
    {
        $fapi = new FstxApi();
        $res = $fapi->query_private('address/get/new', ['is_autoexchange' => 1]);
        if (
            !isset($res['code'])
            || $res['code'] != 0
            || !isset($res['data']['address'])
            || $res['data']['address'] == ''
        ) {
            return false;
        }
        return $res['data']['address'];
    }

    public function orders()
    {
        $orders = Order::whereNotIn('payment_status_id', [6,7])->paginate(5);
        return view('orders.index', compact('orders'));
    }

    //for ajax
    public function getOrderById($id)
    {
        $order = Order::find($id);
        return view('orders.orderrow', compact('order'));
    }

    //for ajax updating status
    public function toHistory(Request $request)
    {
        $order =  Order::find($request->input('id'));
        $order->payment_status_id = ($order->isPaid())?
            Config::get('payment_statuses.HISTORY_OK') :
            Config::get('payment_statuses.HISTORY_WRONG');
        $order->save();
        return response()->json(['result'=>"ok"], 200);
    }

    public function orderInfo($id)
    {
        $order = Order::find($id);
        return view('orders.orderinfo',compact('order'));
    }

    public function history()
    {
        $orders = Order::all()->whereIn('payment_status_id', [6,7] );
        return view('orders.history', compact('orders'));
    }

    public function payInfo($id)
    {
        $order = Order::find($id);
        $order->summ_btc = $order->summ_btc / Config::get('fees.factor');
        $query = $this->getBarCodeQuery($order);
        return view('orders.payinfo',compact('order', 'query'));
    }

    private function getBarCodeQuery(Order $order)
    {

        $btc_rest = $order->summ_uah_rest();

        $query = Config::get('payment.protocol').':'.$order->address.'?amount='.$btc_rest
            .'&label='.Config::get('payment.label').'&message=Order#'.$order->order_number.'.'.$order->description;
//       return rawurlencode($query);
       return ($query);
    }

    public function createOrder()
    {
        return view('orders.create');
    }

    public function ordersApi()
    {
        $orders = Order::all();
        return response()->json(['transaction'=> $orders], 201);

    }
    public function orderApi($id)
    {
        $order = Order::find($id);
        return response()->json([
            'btc_rest'=> $order->summ_btc_rest(),
            'uah_rest'=> $order->summ_uah_rest(),
            'updated_at' => $order->updated_at
        ], 201);

    }
}
