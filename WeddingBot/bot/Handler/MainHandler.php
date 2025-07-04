<?php
namespace Bot\Handler;

use SergiX44\Nutgram\Nutgram;

class MainHandler
{
    public function start(Nutgram $bot)
    {
        sendMessage($bot, "Rasmlarni yuboring:");
    }

    public function photo(Nutgram $bot)
    {
        copyMessage($bot, config('nutgram.group'), $bot->userId(), $bot->messageId());
    }
}
