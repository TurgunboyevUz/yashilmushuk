<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use Bot\Chats\BulkMessage;
use Bot\Chats\CreateChannel;
use Bot\Handlers\Admin;
use Bot\Handlers\User;
use Bot\Middleware\IsAdmin;
use Bot\Middleware\IsSubscribed;
use SergiX44\Nutgram\Nutgram;

$bot->onCommand('start', [User::class, 'start']);
$bot->onCallbackQueryData('back', [User::class, 'back']);

$bot->onCallbackQueryData('pray-time', [User::class, 'pray_time']);
$bot->onCallbackQueryData('pray-lessons', [User::class, 'pray_lessons']);
$bot->onCallbackQueryData('pray-surahs', [User::class, 'pray_surahs']);

$bot->onCallbackQueryData('gender/{gender}', [User::class, 'gender']);

$bot->onCallbackQueryData('video', [User::class, 'video']);
$bot->onCallbackQueryData('page/{page}', [User::class, 'page']);

$bot->onChatJoinRequest([User::class, 'join_request']);

$bot->group(function (Nutgram $bot) {
    $bot->onCallbackQueryData('check', [User::class, 'back']);
    $bot->onCallbackQueryData('time/{id}', [User::class, 'time']);

    $bot->onCallbackQueryData('male/{id}', [User::class, 'male']);
    $bot->onCallbackQueryData('female/{id}', [User::class, 'female']);

    $bot->onCallbackQueryData('surah/{id}', [User::class, 'surah']);
})->middleware(IsSubscribed::class);

$bot->group(function (Nutgram $bot) {
    $bot->onCommand('dashboard', [Admin::class, 'dashboard']);
    $bot->onCallbackQueryData('main', [Admin::class, 'main']);

    $bot->onCallbackQueryData('channel-manager', [Admin::class, 'channel_manager']);
    $bot->onCallbackQueryData('delete/{id}', [Admin::class, 'delete_channel']);

    $bot->onCallbackQueryData('create-channel', CreateChannel::class);
    $bot->onCallbackQueryData('send-message', BulkMessage::class);

    $bot->onCallbackQueryData('update/{id}', [Admin::class, 'update']);
})->middleware(IsAdmin::class);
