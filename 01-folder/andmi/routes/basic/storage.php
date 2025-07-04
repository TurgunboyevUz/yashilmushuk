<?php

use App\Http\Controllers\Basic\ExcelController;
use App\Http\Controllers\Basic\StorageController;
use Illuminate\Support\Facades\Route;

Route::prefix('storage')->group(function () {
    Route::get('/download', [StorageController::class, 'download']);
    Route::post('/zip', [StorageController::class, 'zip']);
});

Route::prefix('excel')->group(function () {
    Route::get('/attached-students', [ExcelController::class, 'attached_students']);
    Route::get('/attached-students-list', [ExcelController::class, 'attached_students_list']);
    Route::get('/distinguished-scholarship', [ExcelController::class, 'distinguished_scholarship']);

    Route::get('/department', [ExcelController::class, 'department']);
    Route::get('/faculty', [ExcelController::class, 'faculty']);
    Route::get('/institute', [ExcelController::class, 'institute']);

    Route::get('/general-faculty', [ExcelController::class, 'general_faculty']);
    Route::get('/general-institute', [ExcelController::class, 'general_institute']);

    Route::get('/student-faculty', [ExcelController::class, 'student_faculty']);
    Route::get('/student-institute', [ExcelController::class, 'student_institute']);
});