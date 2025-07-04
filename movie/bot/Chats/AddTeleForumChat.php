<?php

namespace Bot\Chats;

use App\Models\Forum;
use Bot\Keyboards\Keyboard;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class AddTeleForumChat extends Conversation
{
    use Keyboard;

    public function start(Nutgram $bot)
    {
        editMessageText($bot, "Majburiy a'zolikka kanal qo'shish uchun quyidagi amallarni bajarishingiz kerak:
        
1. Botni kanalga admin qiling.

2. Botga kanaldan istalgan xabarni forward qilib yuboring.", 'html', $this->back_key());

        $this->next('message');
    }

    public function message(Nutgram $bot)
    {
        $forward = $bot->message()->forward_origin;

        if ($forward) {
            $id = $forward->chat->id;
            $title = $forward->chat->title;
            $username = $forward->chat->username ?? null;

            $chat = getChat($bot, $id);

            $invite_link = $chat->invite_link ?? null;

            $forum = Forum::create([
                'tele_id' => $id,

                'title' => $title,
                'username' => $username,

                'link' => $invite_link,

                'by_username' => ! is_null($username),
            ]);

            if ($forum) {
                sendMessage($bot, "Kanal qo'shildi!", 'html', $this->back_key());
            }

            return $this->end();
        }
    }
}
