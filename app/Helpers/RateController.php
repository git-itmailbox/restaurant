<?php
/**
 * Created by PhpStorm.
 * User: yura
 * Date: 19.05.17
 * Time: 10:14
 */

namespace App\Helpers;


use App\FstxApi;
use Illuminate\Support\Facades\Config;

class RateController implements RatesContract
{
    protected $fstx;

    function __construct(FstxApi $fstxApi)
    {
        $this->fstx=$fstxApi;
    }

    public function getBtcUahRate()
    {
        return $this->convertRate($this->getBtcRate(), $this->getUsdUahRate());
    }

    public function getUsdUahRate()
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

    public function getBtcRate()
    {
        $res = $this->fstx->query_public('rate');
        if (isset($res['code']) && $res['code'] == 0)
        {
            $arr_rates['btc_usd'] = round(floor($res['data']['bid']));
        }
        else {
            return false;
        }

        return $arr_rates['btc_usd'];
    }

    private function convertRate($btc_usd, $usd_uah)
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
