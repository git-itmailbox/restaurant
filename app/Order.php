<?php

namespace App;

use App\Helpers\RatesContract;
use Illuminate\Database\Eloquent\Model;

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
    public function summ_uah_rest(RatesContract $rates)
    {
        $btc_rest = $this->summ_btc - $this->paid_btc;
        $uah_rest = ceil($btc_rest * $rates->getBtcUahRate() / Config::get('fees.factor') * 100)/100;
        return $this->hasMany('App\Transaction');
    }
}

