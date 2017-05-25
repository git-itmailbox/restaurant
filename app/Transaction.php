<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public static function findOrCreate($transaction)
    {
        $obj = static::where('transaction_num',$transaction)->first();
        return $obj ?: new static;
    }
}
