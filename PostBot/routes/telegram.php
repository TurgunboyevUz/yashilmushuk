<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use Bot\Middleware\UserMiddleware;
use SergiX44\Nutgram\Nutgram;

$bot->group(function (Nutgram $bot) {
    
})->middleware(UserMiddleware::class);