<?php

namespace Bot\Middleware;

use SergiX44\Nutgram\Nutgram;

class IsAdmin
{
    public function __invoke(Nutgram $bot, $next)
    {
        $admin = explode(',', env('APP_ADMIN', '1804724171'));

        if (!in_array($bot->chatId(), $admin)) {
            return;
        }

        return $next($bot);
    }
}