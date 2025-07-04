<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('/search', [PageController::class, 'search']);

Route::get('/products', [PageController::class, 'products']);
Route::get('/product/{id}', [PageController::class, 'product'])->name('product.detail');

Route::get('/category/{id}', [PageController::class, 'category'])->name('category');

Route::post('/comment/{id}', [PostController::class, 'comment'])->name('product.comment');
Route::post('/order/{id}', [PostController::class, 'order'])->name('product.order');
Route::post('/modal/{id}', [PostController::class, 'modal'])->name('product.modal');

Route::get('/news', [PageController::class, 'news']);
Route::get('/news/{category}', [PageController::class, 'news_category'])->name('news.category');


Route::get('/about', [PageController::class, 'about']);


Route::get('/contact', [PageController::class, 'contact']);
Route::post('/contact', [PostController::class, 'contact']);


Route::get('/page/{slug}', [PageController::class, 'page'])->name('page');

$routes = Route::getRoutes();

foreach ($routes as $route) {
    if (! $route->getName()) {
        $uri = $route->uri();
        $name = str_replace('/', '.', trim($uri, '/'));

        $route->name($name);
    }
}