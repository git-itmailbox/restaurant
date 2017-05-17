<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    //
    protected $orders = [];
    protected $table = "payment_statuses";

    public function orders()
    {
        return $this->hasMany('App\Order');
    }
}
