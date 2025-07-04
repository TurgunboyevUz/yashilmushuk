<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('tree', function () {
    $exclude = [
        'vendor', 'public', 'bootstrap', 'storage', 'config', 'composer.json', 'composer.lock', 'artisan', 'seeders', 'factories'
    ];

    $path = base_path();
    $tree = exec("tree --prune -I '" . implode('|', $exclude) . "' $path", $output);

    foreach ($output as $line) {
        $this->comment($line);
    }
});
