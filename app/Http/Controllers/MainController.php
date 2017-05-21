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
        $order->summ_uah = $request->summ_uah;
        $order->summ_btc = $summBtc;
        $order->description = $request->description;
        $order->order_number = $request->order_number;
        $order->address = $this->getAddress();

        $order->save();
        if($order->order_number == null){
            $order->order_number = "A".$order->id;
            $order->save();
        }

        return DNS2D::getBarcodeHTML($order->address, "QRCODE");
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

    }

    public function orderInfo($id)
    {
        $order = Order::find($id);
        return view('orders.orderinfo',compact('order'));
    }

    public function history()
    {

    }

    public function payInfo($id)
    {
        $order = Order::find($id);
        $order->summ_btc = $order->summ_btc / Config::get('fees.factor');
        $query = Config::get('payment.protocol').':'.$order->address.'?amount='.$order->summ_btc
            .'&label='.Config::get('payment.label').'&message=Order#'.$order->order_number.'.'.$order->description;
        $query  = rawurlencode($query);
        return view('orders.payinfo',compact('order', 'query'));

    }

    public function createOrder()
    {
        return view('orders.create');
    }
}
