<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use Bot\Handler\MainHandler;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\UpdateType;

$bot->onCommand('start', [MainHandler::class, 'start']);

$bot->onPhoto([MainHandler::class, 'photo']);

$bot->onApiError(function(Nutgram $bot, Throwable $e){
    //
});

$bot->onException(function(Nutgram $bot, Throwable $e){
    //
});