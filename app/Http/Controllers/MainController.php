<?php

namespace App\Http\Controllers;

use App\FstxApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class MainController extends Controller
{
    //
    public function home()
    {
//        echo " home";
        $fapi = new FstxApi();
        $fapi->set_privkey(Config::get('fapi.my_private_key'));
        $fapi->set_uid(Config::get('fapi.my_unique_id'));
        $fapi->set_serverpubkey(Config::get('fapi.server_public_key'));

        $res = $fapi->query_public('rate');
        if (isset($res['code']) && $res['code'] == 0)
        {
            $arr_rates['btc_usd'] = round(floor($res['data']['bid']));
        }
        else
        {
            return false;
        }
        return $arr_rates;
    }

    public function getaddress()
    {
//        echo " home";
        $fapi = new FstxApi();
        $fapi->set_privkey(Config::get('fapi.my_private_key'));

        $fapi->set_uid(Config::get('fapi.my_unique_id'));
        $fapi->set_serverpubkey(Config::get('fapi.server_public_key'));
        $res = $fapi->query_private('address/get/new', ['is_autoexchange' => 1]);
        if (
            !isset($res['code'])
            || $res['code'] != 0
            || !isset($res['data']['address'])
            || $res['data']['address'] == ''
        )
        {
            return false;
        }
        return $res['data']['address'];

    }
}
