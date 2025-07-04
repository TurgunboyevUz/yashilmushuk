<?php

namespace Bot\Middleware;

use App\Models\Channel;
use App\Models\Request;
use SergiX44\Nutgram\Nutgram;

class IsSubscribed
{
    public function __invoke(Nutgram $bot, $next)
    {
        $admin = explode(',', env('APP_ADMIN', '1804724171'));

        if (in_array($bot->chatId(), $admin)) {
            return $next($bot);
        }

        $keyboard = $this->check($bot, $bot->chatId());

        if (!is_array($keyboard)) {
            return $next($bot);
        }

        if($bot->callbackQuery()->data == 'check') {
            return answerCallbackQuery($bot, "❗️ Hali kanallarga a'zo bo'lmadingiz!", true);
        }

        if ($bot->callbackQuery()) {
            return editMessageText($bot, "❗️ Iltimos, botdan foydalanish uchun avval quyidagi foydali kanallarga a'zo bo'ling!", 'html', inlineKeyboard($keyboard));
        }

        return sendMessage($bot, "❗️ Iltimos, botdan foydalanish uchun avval quyidagi foydali kanallarga a'zo bo'ling!", 'html', inlineKeyboard($keyboard));
    }

    public function keyboard(&$button, $channel)
    {
        $button[] = ['text' => $channel->title, 'url' => $channel->url];
    }

    public function check(Nutgram $bot, $user_id)
    {
        $keyboard = [];

        $items = Channel::all();

        $request = Request::firstOrCreate(['user_id' => $user_id]);
        $request = json_decode($request->data, true) ?? [];

        foreach ($items as $item) {
            if ($item->is_requested) {
                if (!in_array($item->identifier, $request)) {
                    $this->keyboard($keyboard, $item);
                }
            } else {
                if (!isChatMember($bot, $item->identifier, $user_id)) {
                    $this->keyboard($keyboard, $item);
                }
            }
        }

        if (count($keyboard) > 0) {
            $keyboard[] = ['text' => "✅ Tekshirish", 'callback_data' => 'check'];
            return $keyboard;
        }

        return true;
    }
}
