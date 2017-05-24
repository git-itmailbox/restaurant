<?php

namespace App;

use App\Helpers\RateController;
use App\Helpers\RatesContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Order extends Model
{
    //
    protected $fillable =[
    'order_number', 'payment_status_id', 'summ_btc','summ_uah','address', 'description'
    ];

    public function paymentStatus()
    {
        return $this->belongsTo('App\PaymentStatus');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function summ_uah_rest()
    {
        return ceil($this->summ_uah - $this->paid_uah) / 100;


//        $btc_rest = $this->summ_btc - $this->paid_btc;
//        $uah_rest = ceil($btc_rest * $rates->getBtcUahRate() / Config::get('fees.factor') * 100)/100;
//        return $this->hasMany('App\Transaction');
    }


    public function summ_btc_rest()
    {
        $factor = Config::get('fees.factor');
        $btc_rest = ceil($this->summ_uah_rest() / $this->rate * $factor)  / $factor ;

        return $btc_rest;
    }


}

