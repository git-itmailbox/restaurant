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
        $res = $fapi->query_public('rate');
        if (isset($res['code']) && $res['code'] == 0)
        {
            $arr_rates['btc_usd'] = round(floor($res['data']['bid']));
        }
        else {
            return false;
        }

        $btc_usd = $arr_rates['btc_usd'];
        $usd_uah = $this->getUsdUahRateBuy();
        $client_btc_uah = $this->formatRate($btc_usd, $usd_uah);

        return view('rates.index', ['client_btc_uah'=>$client_btc_uah]);
    }

    private function getUsdUahRateBuy()
    {
        $data = file_get_contents("https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11");
        $list = json_decode($data);
        foreach ($list as $item) {
            if($item->ccy==="USD")
            {
                return $item->buy;
            }
        }
    }

    private function formatRate($btc_usd, $usd_uah)
    {
        $factor=Config::get('fees.factor');
        $btc_usd = $btc_usd/$factor;

        $btc_usd_fee = Config::get('fees.btc_usd');
        $usd_uah_fee = Config::get('fees.usd_uah');

        $client_btc_usd =  $btc_usd*(1-$btc_usd_fee);
        $client_usd_uah =  $usd_uah*(1-$usd_uah_fee);
        $client_btc_uah = $client_btc_usd * $client_usd_uah;
        $client_btc_uah = floor($client_btc_uah*100)/100;
        return $client_btc_uah;
    }
}
