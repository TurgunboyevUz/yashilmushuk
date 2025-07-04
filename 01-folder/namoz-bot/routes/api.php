<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use SergiX44\Nutgram\Nutgram;

Route::post('/hook', function (Nutgram $bot) {
    $bot->run();
});

Route::get('/bulk', function () {
    return Artisan::call('app:bulk');
});
