<?php

use Illuminate\Support\Facades\Route;

$routes = Route::getRoutes();

foreach ($routes as $route) {
    if (! $route->getName()) {
        $uri = $route->uri();
        $name = str_replace('/', '.', trim($uri, '/'));

        $route->name($name);
    }
}
