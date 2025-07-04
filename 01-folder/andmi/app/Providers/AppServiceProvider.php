<?php

namespace App\Providers;

use App\Service\File;
use App\Service\OAuth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        View::addNamespace('layouts', resource_path('layouts'));

        $this->app->bind('oauth', function () {
            return new OAuth;
        });

        $this->app->bind('file', function () {
            return new File;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
