<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/{paysys}/{key}/{data}', [PaymentController::class, 'redirect'])->name('payment.redirect');