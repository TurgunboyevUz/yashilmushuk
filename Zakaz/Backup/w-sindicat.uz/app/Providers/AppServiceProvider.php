<?php

namespace App\Providers;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Classes\SeoManager;
use App\Models\Banner;
use App\Models\Service;
use App\Models\Social;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SeoManager::class, function(){
            return new SeoManager();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        TranslatableTabs::configureUsing(function (TranslatableTabs $component) {
            $component->localesLabels([
                'uz-latn' => "O'zbek (lotin)",
                'uz-cyrl' => "O'zbek (kirill)",
                'ru' => 'Русский',
            ])->locales(['uz-latn', 'uz-cyrl', 'ru']);
        });

        if (! app()->runningInConsole()) {
            $banners = Banner::all();
            $services = Service::where('status', 1)->get();
            $socials = Social::all();

            $phone_number = $socials->where('key', 'phone')->first();
            $phone_number = str_replace('tel:', '', $phone_number->value ?? '');
            $phone_number = substr($phone_number, 0, 4).' '.substr($phone_number, 4, 2).' '.substr($phone_number, 6, 3).' '.substr($phone_number, 9, 2).' '.substr($phone_number, 11, 2);

            View::share(compact('banners', 'services', 'socials', 'phone_number'));
        }
    }
}
