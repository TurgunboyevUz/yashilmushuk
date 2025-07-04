<?php

use App\Http\Controllers\Dean\DeanController;
use App\Http\Controllers\Dean\PageController;
use App\Http\Controllers\Dean\RatingController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [PageController::class, 'dashboard']);
Route::get('edit-profile', [PageController::class, 'edit_profile']);

Route::get('attach-student', [PageController::class, 'attach_student']);
Route::get('attached-students', [PageController::class, 'attached_students']);
Route::get('distinguished-scholarship', [PageController::class, 'distinguished_scholarship']);

Route::get('/department-list/{faculty}', [DeanController::class, 'department_list']);
Route::get('/student-list/{faculty}', [DeanController::class, 'student_list']);
Route::get('/employee-list/{department}', [DeanController::class, 'employee_list']);

Route::post('edit-profile', [DeanController::class, 'edit_profile']);
Route::post('/attach-student', [DeanController::class, 'attach_student']);
Route::delete('/detach-student', [DeanController::class, 'detach_student']);

Route::prefix('rating')->group(function () {
    Route::get('faculty', [RatingController::class, 'faculty']);
    Route::get('institute', [RatingController::class, 'institute']);
    Route::get('general-faculty', [RatingController::class, 'general_faculty']);
    Route::get('general-institute', [RatingController::class, 'general_institute']);
});