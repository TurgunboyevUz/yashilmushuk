<?php

namespace Bot\Chats;

use App\Models\Forum;
use Bot\Keyboards\Keyboard;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class AddOtherForumChat extends Conversation
{
    use Keyboard;

    public $title = null;

    protected function getSerializableAttributes(): array
    {
        return [
            'title' => $this->title
        ];
    }

    public function start(Nutgram $bot)
    {
        editMessageText($bot, "Boshqa turdagi kanal qo'shish uchun quyidagi amallarni bajarishingiz kerak:
        
1. Kanal uchun nom kiriting.

2. Kanal uchun havola kiriting.", 'html', $this->back_key());

        $this->next('title');
    }

    public function title(Nutgram $bot) {
        $text = $bot->message()->text;
        $this->title = $text;

        sendMessage($bot, "Kanal uchun havola kiriting.", 'html', $this->back_key());

        $this->next('link');
    }

    public function link(Nutgram $bot) {
        $link = $bot->message()->text;

        if(str_starts_with($link, 'https://') or str_starts_with($link, 'http://')) {
            $forum = Forum::create([
                'title' => $this->title,
                'link' => $link,
                'is_telegram' => false,
            ]);

            sendMessage($bot, "Kanal muvaffaqiyatli qo'shildi.", 'html', $this->back_key());

            return $this->end();
        }else{
            sendMessage($bot, "Havolani kiritishda xatolikka yo'l qo'yildi, iltimos havolani tekshirgach qayta yuboring", 'html', $this->back_key());
        }
    }
}
