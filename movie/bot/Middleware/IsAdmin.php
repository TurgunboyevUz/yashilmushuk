<?php

namespace Bot\Middleware;

use App\Models\User;
use SergiX44\Nutgram\Nutgram;

class IsAdmin
{
    public function __invoke(Nutgram $bot, $next)
    {
        $user = User::where('user_id', $bot->chatId())->first();

        if ($user->is_admin or $bot->chatId() == config('nutgram.admin')) {
            return $next($bot);
        }
    }
}
