<?php

use Illuminate\Support\Facades\Route;
use TurgunboyevUz\Mirpay\Controllers\MirpayController;

Route::prefix('mirpay')->controller(MirpayController::class)->group(function () {
    Route::post('/success', 'success');
    Route::post('/fail', 'fail');
});