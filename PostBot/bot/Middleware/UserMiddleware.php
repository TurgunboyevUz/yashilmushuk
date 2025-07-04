<?php

namespace Bot\Middleware;

use App\Models\User;
use SergiX44\Nutgram\Nutgram;

class UserMiddleware
{
    public function __invoke(Nutgram $bot, $next)
    {
        $user = User::firstOrCreate(['user_id' => $bot->chatId()], [
            'is_premium' => true,
            'premium_until' => now()->addDays(30)
        ]);

        $bot->set('user', $user);

        $next($bot);
    }
}