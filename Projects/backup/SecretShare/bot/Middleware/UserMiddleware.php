<?php
namespace Bot\Middleware;

use SergiX44\Nutgram\Nutgram;

class UserMiddleware
{
    public function __invoke(Nutgram $bot, $next)
    {
        return $next($bot);
    }
}
