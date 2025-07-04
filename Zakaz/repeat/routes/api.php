<?php

use App\Http\Controllers\AttemptController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;
use TurgunboyevUz\Mirpay\Controllers\MirpayController;

Route::prefix('user')->controller(UserController::class)->group(function () {
    Route::get('profile', 'profile');
    Route::post('profile', 'update');
    Route::get('exams', 'exams');
    Route::get('favourites', 'favourites');
});

Route::prefix('exam')->controller(ExamController::class)->group(function () {
    Route::get('/categories', 'categories');

    Route::get('/', 'all');
    Route::get('/{id}', 'show')->where('id', '[0-9]+');

    Route::post('/{id}/purchase/coin', 'purchaseCoin')->where('id', '[0-9]+');
    Route::post('/{id}/purchase/amount', 'purchaseAmount')->where('id', '[0-9]+');

    Route::post('/{id}/toggle-favourite', 'toggleFavourite')->where('id', '[0-9]+');
    Route::get('/{id}/promocode/validate', 'promocodeValidate')->where('id', '[0-9]+');
});

Route::prefix('package')->controller(PackageController::class)->group(function () {
    Route::get('/', 'all');
    Route::get('/{id}', 'show')->where('id', '[0-9]+');
    Route::post('/{id}/purchase', 'purchase')->where('id', '[0-9]+');
});

Route::prefix('attempt')->controller(AttemptController::class)->group(function () {
    Route::post('/start', 'start');
    Route::post('/finish', 'finish');

    Route::get('/question', 'question');
    Route::post('/answer', 'answer');
});

/*Route::prefix('stats')->controller(AttemptController::class)->group(function () {
    Route::get('/', 'stats');
    Route::get('/top', 'top');
});*/

Route::prefix('mirpay')->withoutMiddleware(UserMiddleware::class)->controller(MirpayController::class)->group(function () {
    Route::get('/success', 'success');
    Route::get('/fail', 'fail');
});
