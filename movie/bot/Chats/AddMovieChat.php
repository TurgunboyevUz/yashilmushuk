<?php

namespace Bot\Chats;

use App\Models\Movie;
use Bot\Keyboards\Keyboard;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class AddMovieChat extends Conversation
{
    use Keyboard;

    public function start(Nutgram $bot)
    {
        editMessageText($bot, "Saqlab olinishi kerak bo'lgan kinoni yuboring:", 'html', $this->back_key());

        $this->next('movie');
    }

    public function movie(Nutgram $bot)
    {
        $video = $bot->message()->video;
        $caption = $bot->message()->caption;

        $file_id = $video->file_id;

        $movie = Movie::create([
            'file_id' => $file_id,
            'caption' => $caption,
        ]);

        sendMessage($bot, "Kino saqlab olindi, kinoni olish uchun kod: <code>{$movie->id}</code>.
Kinoni bazadan o'chirish uchun /del_{$movie->id} buyrug'idan foydalaning.

Kinoga yo'naltirish uchun mahsus havola: https://t.me/".config('nutgram.username')."?start={$movie->id}", 'html');

        $this->end();
    }
}
