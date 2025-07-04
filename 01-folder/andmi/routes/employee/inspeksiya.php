<?php

use App\Http\Controllers\Inspector\ApproveController;
use App\Http\Controllers\Inspector\InspectorController;
use App\Http\Controllers\Inspector\PageController;
use App\Http\Controllers\Inspector\RatingController;
use App\Http\Controllers\Inspector\RejectController;
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
Route::get('evaluation-criteria', [PageController::class, 'evaluation_criteria']);
Route::get('edit-profile', [PageController::class, 'edit_profile']);

Route::post('article/approve', [ApproveController::class, 'article']);
Route::post('scholarship/approve', [ApproveController::class, 'scholarship']);
Route::post('invention/approve', [ApproveController::class, 'invention']);
Route::post('startup/approve', [ApproveController::class, 'startup']);
Route::post('grand-economy/approve', [ApproveController::class, 'grand_economy']);
Route::post('olympics/approve', [ApproveController::class, 'olympics']);
Route::post('lang-certificate/approve', [ApproveController::class, 'lang_certificate']);
Route::post('achievement/approve', [ApproveController::class, 'achievement']);

Route::post('article/reject', [RejectController::class, 'article']);
Route::post('scholarship/reject', [RejectController::class, 'scholarship']);
Route::post('invention/reject', [RejectController::class, 'invention']);
Route::post('startup/reject', [RejectController::class, 'startup']);
Route::post('grand-economy/reject', [RejectController::class, 'grand_economy']);
Route::post('olympics/reject', [RejectController::class, 'olympics']);
Route::post('lang-certificate/reject', [RejectController::class, 'lang_certificate']);
Route::post('achievement/reject', [RejectController::class, 'achievement']);

Route::post('evaluation-criteria', [InspectorController::class, 'evaluation_criteria']);
Route::post('edit-profile', [InspectorController::class, 'edit_profile']);

Route::prefix('rating')->group(function () {
    Route::get('institute', [RatingController::class, 'institute']);
    Route::get('general-institute', [RatingController::class, 'general_institute']);
});
