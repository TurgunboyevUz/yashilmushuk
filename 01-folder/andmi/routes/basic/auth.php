<?php

use App\Http\Controllers\Basic\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'index']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/student/login', [AuthController::class, 'student_url']);
Route::get('/employee/login', [AuthController::class, 'employee_url']);

Route::get('/{type}/oauth', [AuthController::class, 'callback']);
Route::get('/{type}/oauth', [AuthController::class, 'callback']);
