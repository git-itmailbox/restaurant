<?php

namespace App\Http\Controllers;

use App\FstxApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class RatesController extends Controller
{
    public function getRates()
    {
        $fapi = new FstxApi();
        $fapi->set_privkey(Config::get('fapi.my_private_key'));
        $fapi->set_uid(Config::get('fapi.my_unique_id'));
        $fapi->set_serverpubkey(Config::get('fapi.server_public_key'));

        $res = $fapi->query_public('rate');
        if (isset($res['code']) && $res['code'] == 0)
        {
            $arr_rates['btc_usd'] = round(floor($res['data']['bid']));
        }
        else {
            return false;
        }


        $btc_usd_fee = 0.01;//1%
        $usd_uah_fee = 0.02;//2%

        $btc_usd = $arr_rates['btc_usd'];
        $FACTOR=100000000;
        $btc_usd = $btc_usd/$FACTOR;
        $data = file_get_contents("https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11");
        $list = json_decode($data);
        $ccy_usd=[];
        foreach ($list as $item) {
            if($item->ccy==="USD")
            {
                $ccy_usd=$item;
            }
        }
        $usd_uah = $ccy_usd->buy;

        $client_btc_usd =  $btc_usd*(1-$btc_usd_fee);
        $client_usd_uah=  $usd_uah*(1-$usd_uah_fee);
        $client_btc_uah = $client_btc_usd * $client_usd_uah;
        $client_btc_uah = floor($client_btc_uah*100)/100;
//        return $client_btc_uah;
        return view('rates.index', ['client_btc_uah'=>$client_btc_uah]);
    }
}
