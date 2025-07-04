<?php

use App\Http\Controllers\Talent\ApproveController;
use App\Http\Controllers\Talent\PageController;
use App\Http\Controllers\Talent\RatingController;
use App\Http\Controllers\Talent\RejectController;
use App\Http\Controllers\Talent\TalentController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [PageController::class, 'dashboard']);
Route::get('edit-profile', [PageController::class, 'edit_profile']);
Route::get('distinguished-scholarship', [PageController::class, 'distinguished_scholarship']);

Route::post('distinguished-scholarship/approve', ApproveController::class);
Route::post('distinguished-scholarship/reject', RejectController::class);
Route::post('edit-profile', [TalentController::class, 'edit_profile']);

Route::get('student-list', [PageController::class, 'student_list']);

Route::prefix('rating')->group(function () {
    Route::get('institute', [RatingController::class, 'institute']);
    Route::get('general-institute', [RatingController::class, 'general_institute']);
});
