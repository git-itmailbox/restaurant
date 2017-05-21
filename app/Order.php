<?php

namespace App;

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

}

