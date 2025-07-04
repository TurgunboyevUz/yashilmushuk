<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait ConsoleLog
{
    public function log($message, $context = [])
    {
        Log::channel('stderr')->info($message, $context);
    }
}