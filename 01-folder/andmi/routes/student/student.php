<?php

use App\Http\Controllers\Student\FileController;
use App\Http\Controllers\Student\PageController;
use Illuminate\Support\Facades\Route;

$routes = function () {
    Route::get('dashboard', [PageController::class, 'dashboard']);

    Route::get('article', [PageController::class, 'article']);
    Route::get('assignments', [PageController::class, 'assignments']);
    Route::get('scholarship', [PageController::class, 'scholarship']);
    Route::get('invention', [PageController::class, 'invention']);
    Route::get('startup', [PageController::class, 'startup']);
    Route::get('grand-economy', [PageController::class, 'grand_economy']);
    Route::get('olympics', [PageController::class, 'olympics']);
    Route::get('lang-certificate', [PageController::class, 'lang_certificate']);
    Route::get('distinguished-scholarship', [PageController::class, 'distinguished_scholarship']);
    Route::get('achievement', [PageController::class, 'achievement']);
    Route::get('evaluation-criteria', [PageController::class, 'evaluation_criteria']);
    Route::get('chat', [PageController::class, 'chat']);

    Route::post('article', [FileController::class, 'article']);
    Route::post('scholarship', [FileController::class, 'scholarship']);
    Route::post('invention', [FileController::class, 'invention']);
    Route::post('startup', [FileController::class, 'startup']);
    Route::post('grand-economy', [FileController::class, 'grand_economy']);
    Route::post('olympics', [FileController::class, 'olympics']);
    Route::post('lang-certificate', [FileController::class, 'lang_certificate']);
    Route::post('distinguished-scholarship', [FileController::class, 'distinguished_scholarship']);
    Route::post('achievement', [FileController::class, 'achievement']);
    Route::post('evaluation-criteria', [FileController::class, 'evaluation_criteria']);
    Route::post('chat', [FileController::class, 'chat']);

    Route::delete('article/destroy', [FileController::class, 'destroy_article']);
    Route::delete('scholarship/destroy', [FileController::class, 'destroy_scholarship']);
    Route::delete('invention/destroy', [FileController::class, 'destroy_invention']);
    Route::delete('startup/destroy', [FileController::class, 'destroy_startup']);
    Route::delete('grand-economy/destroy', [FileController::class, 'destroy_grand_economy']);
    Route::delete('olympics/destroy', [FileController::class, 'destroy_olympics']);
    Route::delete('lang-certificate/destroy', [FileController::class, 'destroy_lang_certificate']);
    Route::delete('distinguished-scholarship/destroy', [FileController::class, 'destroy_distinguished_scholarship']);
    Route::delete('achievement/destroy', [FileController::class, 'destroy_achievement']);

    Route::prefix('/rating')->group(function () {
        Route::get('faculty', [PageController::class, 'faculty_rating']);
        Route::get('institute', [PageController::class, 'institute_rating']);
    });
};

Route::prefix('student')->middleware(['auth', 'locale', 'role:student'])->group($routes);
