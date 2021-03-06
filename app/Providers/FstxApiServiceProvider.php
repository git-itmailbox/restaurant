<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\FstxApi;

class FstxApiServiceProvider extends ServiceProvider
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
        //
        $this->app->singleton('App\Providers\FstxApiServiceProvider', function (FstxApi $fstxApi) {
                return new FstxApi();
        });
    }
}
