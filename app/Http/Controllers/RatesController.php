<?php

namespace App\Http\Controllers;

use App\Helpers\RatesContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class RatesController extends Controller
{
    public function getRates(RatesContract $rates)
    {
        $client_btc_uah = $rates->getBtcUahRate();
        return view('rates.index', ['client_btc_uah'=>$client_btc_uah]);
    }

}
