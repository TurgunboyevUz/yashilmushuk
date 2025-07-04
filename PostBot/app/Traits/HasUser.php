<?php

namespace App\Traits;

use App\Models\User;
use SergiX44\Nutgram\Nutgram;

trait HasUser
{
    public function user(Nutgram $bot)
    {
        if(!$bot->get('user'))
        {
            $user = User::where('user_id', $bot->chatId())->first();
            $bot->set('user', $user);
        }

        return $bot->get('user');
    }
}