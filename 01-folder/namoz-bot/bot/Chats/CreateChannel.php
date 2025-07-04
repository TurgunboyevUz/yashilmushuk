<?php

namespace Bot\Chats;

use App\Models\Channel;
use Bot\Keyboards\Dashboard;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class CreateChannel extends Conversation
{
    use Dashboard;

    public $title;
    public $id;
    public $url;

    protected function getSerializableAttributes(): array
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'title' => $this->title
        ];
    }

    public function start(Nutgram $bot)
    {
        editMessageText($bot, "Kanal nomini kiriting!", 'html', $this->back_key());

        $this->next('title');
    }

    public function title(Nutgram $bot)
    {
        $this->title = $bot->message()->text;

        sendMessage($bot, "Kanal ID raqamini kiriting!", 'html', $this->back_key());

        $this->next('id');
    }

    public function id(Nutgram $bot)
    {
        $id = $bot->message()->text;

        if(!is_numeric($id)){
            return sendMessage($bot, "Kanal ID raqamida harflar bo'lishi mumkin emas, iltimos to'g'ri ID raqam kiriting:", 'html', $this->back_key());
        }

        if (Channel::where('identifier', $id)->exists()) {
            return sendMessage($bot, "Bu ID raqamli kanal mavjud, iltimos boshqa ID raqam kiriting", 'html', $this->back_key());
        }

        $this->id = $id;

        sendMessage($bot, "Kanal uchun havola kiriting:", 'html', $this->back_key());

        $this->next('url');
    }

    public function url(Nutgram $bot)
    {
        $url = $bot->message()->text;

        if(!filter_var($url, FILTER_VALIDATE_URL) or !str_starts_with($url, 'https://t.me/')){
            return sendMessage($bot, "Kanal havolasi noto'g'ri, iltimos to'g'ri havola kiriting:", 'html', $this->back_key());
        }

        $this->url = $url;

        sendMessage($bot, "Kanal turini tanlang:", 'html', $this->type_key());

        $this->next('is_requested');
    }

    public function is_requested(Nutgram $bot)
    {
        $data = $bot->callbackQuery()->data;
        $ex = explode('/', $data);

        if($ex[1] == 'simple'){
            $is_requested = false;
        }elseif($ex[1] == 'requested'){
            $is_requested = true;
        }else{
            return;
        }

        Channel::create([
            'title' => $this->title,
            'identifier' => $this->id,
            'url' => $this->url,
            'is_requested' => $is_requested
        ]);

        editMessageText($bot, "Kanal muvaffaqiyatli yaratildi", 'html', $this->back_key());

        if(!isChatMember($bot, $this->id, $bot->getMe()->id)){
            sendMessage($bot, "Qo'shilgan kanalda bot administrator emas, botni administratorlar ro'yxatiga qo'shishni unutmang!", 'html', $this->back_key());
        }

        $this->end();
    }
}