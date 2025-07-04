<?php

use App\Http\Controllers\Teacher\FileController;
use App\Http\Controllers\Teacher\PageController;
use App\Http\Controllers\Teacher\RatingController;
use App\Http\Controllers\Teacher\RejectController;
use App\Http\Controllers\Teacher\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [PageController::class, 'dashboard']);

Route::get('article', [PageController::class, 'article']);
Route::get('scholarship', [PageController::class, 'scholarship']);
Route::get('invention', [PageController::class, 'invention']);
Route::get('startup', [PageController::class, 'startup']);
Route::get('grand-economy', [PageController::class, 'grand_economy']);
Route::get('olympics', [PageController::class, 'olympics']);
Route::get('lang-certificate', [PageController::class, 'lang_certificate']);
Route::get('distinguished-scholarship', [PageController::class, 'distinguished_scholarship']);
Route::get('achievement', [PageController::class, 'achievement']);
Route::get('chat', [PageController::class, 'chat']);
Route::get('student-list', [PageController::class, 'student_list']);
Route::get('tasks', [PageController::class, 'task']);
Route::get('edit-profile', [PageController::class, 'edit_profile']);

Route::post('article/review', [ReviewController::class, 'article']);
Route::post('scholarship/review', [ReviewController::class, 'scholarship']);
Route::post('invention/review', [ReviewController::class, 'invention']);
Route::post('startup/review', [ReviewController::class, 'startup']);
Route::post('grand-economy/review', [ReviewController::class, 'grand_economy']);
Route::post('olympics/review', [ReviewController::class, 'olympics']);
Route::post('lang-certificate/review', [ReviewController::class, 'lang_certificate']);
Route::post('achievement/review', [ReviewController::class, 'achievement']);

Route::post('article/reject', [RejectController::class, 'article']);
Route::post('scholarship/reject', [RejectController::class, 'scholarship']);
Route::post('invention/reject', [RejectController::class, 'invention']);
Route::post('startup/reject', [RejectController::class, 'startup']);
Route::post('grand-economy/reject', [RejectController::class, 'grand_economy']);
Route::post('olympics/reject', [RejectController::class, 'olympics']);
Route::post('lang-certificate/reject', [RejectController::class, 'lang_certificate']);
Route::post('achievement/reject', [RejectController::class, 'achievement']);

Route::post('tasks', [FileController::class, 'task']);
Route::delete('tasks/destroy', [FileController::class, 'destroy_task']);

Route::post('edit-profile', [FileController::class, 'edit_profile']);

Route::prefix('rating')->group(function () {
    Route::get('attached-students', [RatingController::class, 'attached_students']);
    Route::get('department', [RatingController::class, 'department']);
    Route::get('faculty', [RatingController::class, 'faculty']);
    Route::get('institute', [RatingController::class, 'institute']);
    Route::get('general-institute', [RatingController::class, 'general_institute']);
});
