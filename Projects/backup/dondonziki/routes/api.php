<?php

use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

Route::post('webhook', FrontController::class);