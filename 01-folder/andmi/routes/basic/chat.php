<?php

use App\Http\Controllers\Basic\ChatController;
use Illuminate\Support\Facades\Route;

Route::prefix('chat')->middleware(['auth', 'locale'])->group(function () {
    Route::get('/{chat}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');

    Route::post('/{chat}/sendMessage', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
    Route::post('/{chat}/deleteMessage', [ChatController::class, 'deleteMessage'])->name('chat.deleteMessage');
});