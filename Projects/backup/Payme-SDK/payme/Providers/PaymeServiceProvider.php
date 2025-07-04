<?php

namespace Payme;

use Illuminate\Support\ServiceProvider;

class PaymeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/payme.php', 'payme');

        $this->app->singleton('payme', function () {
            return new Payme();
        });
    }
}