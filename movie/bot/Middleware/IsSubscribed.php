<?php

namespace Bot\Middleware;

use App\Models\Forum;
use App\Models\User;
use Bot\Keyboards\Keyboard;
use SergiX44\Nutgram\Nutgram;

class IsSubscribed
{
    use Keyboard;

    public function __invoke(Nutgram $bot, $next)
    {
        $user = User::where('user_id', $bot->chatId())->first();
        $forums = Forum::with('invites', 'invites.user')->get();

        $invitable = $forums->where('invitable', true)->where('is_telegram', true);
        $non_invitable = $forums->where('invitable', false)->where('is_telegram', true);

        foreach ($invitable as $forum) {
            if(!$forum->invites->where('user_id', $user->id)->first()) {
                return $this->not_subscribed($bot, $forums);
            }
        }

        foreach ($non_invitable as $forum) {
            if(!isChatMember($bot, $forum->tele_id, $bot->chatId())) {
                return $this->not_subscribed($bot, $forums);
            }
        }

        $next($bot);
    }

    public function not_subscribed(Nutgram $bot, $forums)
    {
        if($bot->callbackQuery()){
            $bot->message()->delete();
        }
        
        return sendMessage($bot, "<b>🤖🤚 Kechirasiz botimizdan to'liq foydalanish uchun ushbu kanallarga a'zo bo'lishingiz kerak👇</b>", 'html', $this->subscribe_key($forums));
    }
}
