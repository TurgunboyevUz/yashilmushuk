<?php

use App\Http\Controllers\Basic\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'welcome']);
Route::get('/locale', [MainController::class, 'locale']);

require_once __DIR__ . '/student/student.php';
require_once __DIR__ . '/employee/employee.php';

require_once __DIR__ . '/basic/auth.php';
require_once __DIR__ . '/basic/chat.php';
require_once __DIR__ . '/basic/storage.php';
require_once __DIR__ . '/basic/rename.php';
