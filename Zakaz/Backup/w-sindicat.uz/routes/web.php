<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceController;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{lang}', [PageController::class, 'locale'])->name('locale');

Route::middleware(LocaleMiddleware::class)->group(function () {
    Route::controller(PageController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/about', 'about')->name('about');
        Route::get('/faq', 'faq')->name('faq');
        Route::get('/contacts', 'contacts')->name('contacts');
    });

    Route::prefix('services')->controller(ServiceController::class)->name('services.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{slug}', 'show')->name('show');
    });

    Route::prefix('catalog')->controller(CatalogController::class)->name('catalog.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{catalog}/{slug}', 'show')->name('show');
    });

    Route::prefix('blog')->controller(BlogController::class)->name('blog.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{slug}', 'show')->name('show');
    });
});
