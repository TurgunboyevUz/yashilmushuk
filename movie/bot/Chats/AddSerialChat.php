<?php

namespace Bot\Chats;

use App\Models\Movie;
use Bot\Keyboards\Keyboard;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class AddSerialChat extends Conversation
{
    use Keyboard;

    public array $serials = [];

    protected function getSerializableAttributes(): array
    {
        return [
            'serials' => $this->serials,
        ];
    }

    public function start(Nutgram $bot)
    {
        editMessageText($bot, "Saqlab olinishi kerak bo'lgan seriallarni yuboring:", 'html', $this->back_key());

        $this->next('movie');
    }

    public function movie(Nutgram $bot)
    {
        if ($bot->callbackQuery()?->data == 'finish') {
            $movie = Movie::create();

            print_r($this->serials);

            $movie->serials()->createMany($this->serials);

            editMessageText($bot, "Serial saqlab olindi, kinoni olish uchun kod: <code>{$movie->id}</code>.
Kinoni bazadan o'chirish uchun /del_{$movie->id} buyrug'idan foydalaning.

Kinoga yo'naltirish uchun mahsus havola: https://t.me/".config('nutgram.username')."?start={$movie->id}", 'html');

            $this->end();
        } else {
            $video = $bot->message()->video;
            $caption = $bot->message()->caption;

            $file_id = $video->file_id;

            $this->serials[] = [
                'file_id' => $file_id,
                'caption' => $caption,
            ];

            sendMessage($bot, 'Saqlab olindi, serial yuklashni yakunlash uchun quyidagi tugmadan foydalaning', 'html', $this->finish_serial_key());

            $this->next('movie');
        }
    }
}
