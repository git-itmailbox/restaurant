<?php

namespace App\Providers;

use App\FstxApi;
use App\Helpers\RateController;
use Illuminate\Support\ServiceProvider;

class RatesProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Helpers\RatesContract', function(){

            return new RateController(new FstxApi() );
        });
    }
}
