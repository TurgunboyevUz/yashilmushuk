<?php

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ChatMemberStatus;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton as InlineButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup as InlineKeyboard;
use SergiX44\Nutgram\Telegram\Types\Keyboard\ReplyKeyboardRemove as RemoveKeyboard;

function sendMessage(Nutgram $bot, $text, $parse_mode = 'html', $reply_markup = null, $chat_id = null)
{
    $parse_mode = ($parse_mode == 'html') ? ParseMode::HTML : ParseMode::MARKDOWN;

    return $bot->sendMessage(...compact('chat_id', 'text', 'parse_mode', 'reply_markup'));
}

function editMessageText(Nutgram $bot, $text, $parse_mode = 'html', $reply_markup = null, $chat_id = null, $message_id = null)
{
    $parse_mode = ($parse_mode == 'html') ? ParseMode::HTML : ParseMode::MARKDOWN;

    return $bot->editMessageText(...compact('chat_id', 'message_id', 'text', 'parse_mode', 'reply_markup'));
}

function deleteMessage(Nutgram $bot, $chat_id = null, $message_id = null)
{
    if (empty($chat_id) || empty($message_id)) {
        return $bot->message()->delete();
    } else {
        return $bot->deleteMessage(...compact('chat_id', 'message_id'));
    }
}

function copyMessage(Nutgram $bot, $chat_id = null, $from_chat_id = null, $message_id = null, $caption = null, $parse_mode = 'html', $reply_markup = null)
{
    $parse_mode = ($parse_mode == 'html') ? ParseMode::HTML : ParseMode::MARKDOWN;

    return $bot->copyMessage(...compact('chat_id', 'from_chat_id', 'message_id', 'caption', 'parse_mode', 'reply_markup'));
}

function forwardMessage(Nutgram $bot, $chat_id = null, $from_chat_id = null, $message_id = null)
{
    return $bot->forwardMessage(...compact('chat_id', 'from_chat_id', 'message_id'));
}

function editMessageReplyMarkup(Nutgram $bot, $reply_markup = null, $chat_id = null, $message_id = null)
{
    return $bot->editMessageReplyMarkup(...compact('chat_id', 'message_id', 'reply_markup'));
}

function answerCallbackQuery(Nutgram $bot, $text, $show_alert)
{
    return $bot->answerCallbackQuery(...compact('text', 'show_alert'));
}

function isChatMember(Nutgram $bot, $chat_id, $user_id = null)
{
    $user_id = $user_id ?? $bot->chatId();
    $status = $bot->getChatMember($chat_id, $user_id)->status;

    return $status == ChatMemberStatus::MEMBER || $status == ChatMemberStatus::CREATOR || $status == ChatMemberStatus::ADMINISTRATOR;
}

function isChatAdmin(Nutgram $bot, $chat_id, $user_id = null)
{
    $user_id = $user_id ?? $bot->chatId();
    $status = $bot->getChatMember($chat_id, $user_id)->status;

    return $status == ChatMemberStatus::ADMINISTRATOR || $status == ChatMemberStatus::CREATOR;
}

function inlineKeyboard($buttons): InlineKeyboard
{
    $keyboard = InlineKeyboard::make();

    $makeButton = function ($button) {
        return InlineButton::make(...$button);
    };

    $makeRow = function ($buttons) use ($makeButton) {
        $row = [];

        if(array_keys($buttons) === range(0, count($buttons) - 1)) {
            foreach ($buttons as $button) {
                $row[] = $makeButton($button);
            }

            return $row;
        }else{
            return [$makeButton($buttons)];
        }
    };

    foreach ($buttons as $row) {
        $current_row = $makeRow($row);

        $keyboard->addRow(...$current_row);
    }

    return $keyboard;
}

function removeKeyboard()
{
    return RemoveKeyboard::make(true);
}