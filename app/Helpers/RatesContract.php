<?php
/**
 * Created by PhpStorm.
 * User: yura
 * Date: 19.05.17
 * Time: 10:12
 */

namespace App\Helpers;

interface RatesContract
{
    public function getBtcUahRate();

    public function getUsdUahRate();

    public function getBtcRate();

}