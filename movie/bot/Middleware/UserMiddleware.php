<?php

namespace Bot\Middleware;

use App\Models\User;
use SergiX44\Nutgram\Nutgram;

class UserMiddleware
{
    public function __invoke(Nutgram $bot, $next)
    {
        User::firstOrCreate(['user_id' => $bot->chatId()]);

        $next($bot);
    }
}
