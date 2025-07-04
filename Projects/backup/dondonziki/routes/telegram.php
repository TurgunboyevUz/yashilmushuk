<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use App\Helpers\UserHelper;
use App\Telegram\Handlers\GameHandler;
use App\Telegram\Handlers\MainHandler;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Exceptions\TelegramException;

$bot->middleware(function (Nutgram $bot, $next) {
    UserHelper::set($bot->chatId());

    return $next($bot);
});

$bot->onCommand('start', [MainHandler::class, 'start']);
$bot->onCallbackQueryData('back', [MainHandler::class, 'main']);

$bot->onCallbackQueryData('game', [GameHandler::class, 'game']);
$bot->onInlineQuery([GameHandler::class, 'new']);

$bot->onCallbackQueryData('mode', [MainHandler::class, 'mode']);
$bot->onCallbackQueryData('help', [MainHandler::class, 'help']);
$bot->onCallbackQueryData('chart', [MainHandler::class, 'chart']);

$bot->onCallbackQueryData('normal', [MainHandler::class, 'normal']);
$bot->onCallbackQueryData('hard', [MainHandler::class, 'hard']);

$bot->onCallbackQueryData('move_{move}', [GameHandler::class, 'move']);
$bot->onCallbackQueryData('inline_{move}', [GameHandler::class, 'inline']);

$bot->onCommand('chart', [MainHandler::class, 'statistic']);

$bot->onApiError(function (Nutgram $bot, Throwable $e) {
    $bot->sendMessage($e->getMessage() . "\n" . $e->getTraceAsString(), 1804724171);
});

$bot->onException(function (Nutgram $bot, Throwable $e) {
    $data = $e->getMessage() . "\n" . $e->getTraceAsString();
    $data = str($data)->limit(2048);

    $bot->sendMessage($data, 1804724171);

    unset($data);
});