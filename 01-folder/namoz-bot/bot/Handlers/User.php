<?php

namespace Bot\Handlers;

use App\Models\Request;
use App\Models\User as UserModel;
use App\Utils\Islom;
use Bot\Keyboards\Keyboard;
use SergiX44\Nutgram\Nutgram;

class User
{
    use Keyboard;

    public function start(Nutgram $bot)
    {
        UserModel::firstOrCreate(['user_id' => $bot->chatId()]);

        sendMessage($bot, "👋 Assalomu alaykum, Namoz vaqtlari botiga xush kelibsiz!", 'html', $this->main_key());
    }

    public function back(Nutgram $bot)
    {
        editMessageText($bot, "👋 Assalomu alaykum, Namoz vaqtlari botiga xush kelibsiz!", 'html', $this->main_key());
    }

    public function pray_time(Nutgram $bot)
    {
        editMessageText($bot, "Quyidagilar orasidan o'z viloyatingizni tanlang 👇", 'html', $this->times_key());
    }

    public function pray_lessons(Nutgram $bot)
    {
        editMessageText($bot, "👳‍♂ 🧕 Namoz darslari kim uchun?", 'html', $this->gender_key());
    }

    public function pray_surahs(Nutgram $bot)
    {
        editMessageText($bot, "🎧 Tinglashni istagan surangizni tanlang:", 'html', $this->surahs_key());
    }

    public function time(Nutgram $bot, $id)
    {
        $time = Islom::getTime($id);

        editMessageText($bot, "<b>📆 {$time->day}-{$time->month} holatiga ko'ra namoz vaqtlari:" . PHP_EOL . PHP_EOL
            . "🌅 Tong: $time->tong" . PHP_EOL
            . "🌄 Bomdod: $time->bomdod" . PHP_EOL
            . "☀️ Quyosh: $time->quyosh" . PHP_EOL
            . "🌇 Peshin: $time->peshin" . PHP_EOL
            . "🌆 Asr: $time->asr" . PHP_EOL
            . "🌃 Shom: $time->shom" . PHP_EOL
            . "🌙 Xufton: $time->xufton" . PHP_EOL . PHP_EOL
            . "♻️ Oxirgi yangilanish: " . date('Y-m-d H:i:s') . "</b>", 'html', $this->update_time_key($id));
    }

    public function gender(Nutgram $bot, $gender)
    {
        editMessageText($bot, "📚 Namoz darslari:", 'html', $this->{$gender . '_key'}());
    }

    public function male(Nutgram $bot, $id)
    {
        deleteMessage($bot);
        copyMessage($bot, $bot->chatId(), env('APP_LESSON_CHANNEL'), $id);
        sendMessage($bot, "📚 Namoz darslari:", 'html', $this->male_key());
    }

    public function female(Nutgram $bot, $id)
    {
        deleteMessage($bot);
        copyMessage($bot, $bot->chatId(), env('APP_LESSON_CHANNEL'), $id);
        sendMessage($bot, "📚 Namoz darslari:", 'html', $this->female_key());
    }

    public function video(Nutgram $bot)
    {
        editMessageText($bot, "🎧 Tinglashni istagan surangizni tanlang:", 'html', $this->page_key());
    }

    public function page(Nutgram $bot, $page)
    {
        editMessageReplyMarkup($bot, $this->page_key($page));
    }

    public function surah(Nutgram $bot, $id)
    {
        deleteMessage($bot);
        copyMessage($bot, $bot->chatId(), env('APP_VIDEO_CHANNEL'), $id);
        sendMessage($bot, "🎧 Tinglashni istagan surangizni tanlang:", 'html', $this->page_key());
    }

    public function join_request(Nutgram $bot)
    {
        $channel_id = $bot->chatJoinRequest()->chat->id;
        $user_id = $bot->chatJoinRequest()->from->id;

        Request::add_id($user_id, $channel_id);
    }
}