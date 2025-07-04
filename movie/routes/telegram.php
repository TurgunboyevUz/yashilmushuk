<?php

/** @var SergiX44\Nutgram\Nutgram $bot */

use Bot\Chats\AddMovieChat;
use Bot\Chats\AddOtherForumChat;
use Bot\Chats\AddSerialChat;
use Bot\Chats\AddTeleForumChat;
use Bot\Chats\BulkTypeChat;
use Bot\Chats\LinkForumChat;
use Bot\Handlers\AdminHandler;
use Bot\Handlers\MainHandler;
use Bot\Middleware\IsAdmin;
use Bot\Middleware\IsSubscribed;
use Bot\Middleware\UserMiddleware;
use SergiX44\Nutgram\Nutgram;

$bot->group(function (Nutgram $bot) {
    $bot->onCommand('start', [MainHandler::class, 'start']);
    $bot->onCommand('start {code}', [MainHandler::class, 'start_code']);
})->middleware(UserMiddleware::class);

$bot->onCallbackQueryData('page_{movie}_{page}', [MainHandler::class, 'serial_page']);
$bot->onCallbackQueryData('remove', [MainHandler::class, 'remove']);

$bot->group(function (Nutgram $bot) {
    $bot->onText('^\d+$', [MainHandler::class, 'code']);
    $bot->onCallbackQueryData('serial_{index}_{id}', [MainHandler::class, 'serial']);
})->middleware(IsSubscribed::class);

$bot->onCallbackQueryData('subscribe', [MainHandler::class, 'subscribe']);
$bot->onChatJoinRequest([MainHandler::class, 'join_request']);

$bot->group(function (Nutgram $bot) {

    $bot->onCommand('dash', [AdminHandler::class, 'dash']);
    $bot->onCallbackQueryData('back', [AdminHandler::class, 'back']);

    $bot->onCallbackQueryData('add_movie', AddMovieChat::class);
    $bot->onCallbackQueryData('add_serial', AddSerialChat::class);
    $bot->onCommand('del_{id}', [AdminHandler::class, 'del']);

    $bot->onCallbackQueryData('add_tele_forum', AddTeleForumChat::class);
    $bot->onCallbackQueryData('add_other_forum', AddOtherForumChat::class);

    $bot->onCallbackQueryData('forums', [AdminHandler::class, 'forums']);
    $bot->onCallbackQueryData('add_forum', [AdminHandler::class, 'add_forum']);
    $bot->onCallbackQueryData('delete_forum_(\d+)', [AdminHandler::class, 'delete_forum']);

    $bot->onCallbackQueryData('edit_forum_(\d+)', [AdminHandler::class, 'edit_forum']);
    $bot->onCallbackQueryData('update_forum_(\d+)', [AdminHandler::class, 'update_forum']);
    $bot->onCallbackQueryData('type_forum_(\d+)', [AdminHandler::class, 'type_forum']);
    $bot->onCallbackQueryData('invite_forum_(\d+)', [AdminHandler::class, 'invite_forum']);

    $bot->onCallbackQueryData('link_forum_(\d+)', LinkForumChat::class);

    $bot->onCallbackQueryData('chart', [AdminHandler::class, 'chart']);

    $bot->onCommand('add_admin_(\d+)', [AdminHandler::class, 'add_admin']);
    $bot->onCommand('del_admin_(\d+)', [AdminHandler::class, 'del_admin']);

    $bot->onCallbackQueryData('bulk', [AdminHandler::class, 'bulk']);
    $bot->onCallbackQueryData('bulk_{type}', BulkTypeChat::class);
})->middleware(IsAdmin::class);

$bot->onException(function (Throwable $e, Nutgram $bot) {
    //Log::channel('stderr')->error('Error: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
});
