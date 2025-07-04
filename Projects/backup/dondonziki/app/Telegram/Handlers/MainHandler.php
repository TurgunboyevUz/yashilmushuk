<?php

namespace App\Telegram\Handlers;

use App\Models\Game;
use App\Models\User;
use App\Traits\UserTrait;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton as Button;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup as Markup;

class MainHandler
{
    use UserTrait;

    public function mainKeyboard()
    {
        $buttons = Markup::make();
        $buttons->addRow(
            Button::make(text: "👾 O'yinni boshlash", callback_data: 'game')
        );

        $buttons->addRow(
            Button::make(text: "👥 Do'stlar bilan o'ynash", switch_inline_query: 'new')
        );

        $buttons->addRow(
            Button::make(text: "📊 Statistika", callback_data: 'chart')
        );

        $buttons->addRow(
            Button::make(text: "⚙️ Rejim", callback_data: 'mode'),
            Button::make(text: "📚 Yordam", callback_data: 'help')
        );

	$buttons->addRow(
	    Button::make(text: "Qo'llab-quvvatlash 💳", url: 'https://tirikchilik.uz/dondonziki')
	);

        return $buttons;
    }

    public function modeKeyboard()
    {
        $buttons = Markup::make();

        $buttons->addRow(
            Button::make(text: "⚖️ Oson", callback_data: 'normal'),
            Button::make(text: "🧨 Qiyin", callback_data: 'hard')
        );

        $buttons->addRow(
            Button::make(text: "🔙 Orqaga", callback_data: 'back')
        );

        return $buttons;
    }

    public function backKeyboard()
    {
        $buttons = Markup::make();

        $buttons->addRow(
            Button::make(text: "🔙 Orqaga", callback_data: 'back')
        );

        return $buttons;
    }

    public function start(Nutgram $bot)
    {
        $bot->sendMessage(
            text: "Assalomu alaykum, {$bot->chat()->first_name} 👋",
            parse_mode: ParseMode::HTML,
            reply_markup: $this->mainKeyboard()
        );
    }

    public function main(Nutgram $bot)
    {
        $bot->editMessageText(
            text: "Assalomu alaykum, {$bot->chat()->first_name} 👋",
            parse_mode: ParseMode::HTML,
            reply_markup: $this->mainKeyboard()
        );
    }

    public function mode(Nutgram $bot)
    {
        $bot->editMessageText(
            text: "👇 Quyidagilardan o'zingiz uchun qulay rejimni tanlang:",
            parse_mode: ParseMode::HTML,
            reply_markup: $this->modeKeyboard()
        );
    }

    public function normal(Nutgram $bot)
    {
        $this->update('mode', '1');

        $bot->editMessageText(
            text: "Endilikda siz oson rejimida o'yinni davom ettirasiz ✅",
            parse_mode: ParseMode::HTML,
            reply_markup: $this->mainKeyboard()
        );
    }

    public function hard(Nutgram $bot)
    {
        $this->update('mode', '2');

        $bot->editMessageText(
            text: "Endilikda siz qiyin rejimida o'yinni davom ettirasiz ✅",
            parse_mode: ParseMode::HTML,
            reply_markup: $this->mainKeyboard()
        );
    }

    public function help(Nutgram $bot)
    {
        $bot->editMessageText(
            text: "🤖 Ushbu bot orqali barchamizga yaxshi tanish bo'lgan \"Tosh,qaychi,qog'oz\" o'yinini bot yoki do'stlaringiz bilan birgalikda online o'ynashingiz mumkin.\n\nBot yaratuvchisi: @OnlineWolf",
            parse_mode: ParseMode::HTML,
            reply_markup: $this->backKeyboard()
        );
    }

    public function chart(Nutgram $bot)
    {
        $user = $this->user();

        $bot->editMessageText(
            text: "📊 Statistika:

🤖 Bot bilan o'yinlar
🏆 G'oliblik: {$user->win}
🤝 Durrang: {$user->draw}
😞 Mag'lublik: {$user->lose}

👥 Do'stlar bilan o'yinlar
🏆 G'oliblik: {$user->inline_win}
🤝 Durrang: {$user->inline_draw}
😞 Mag'lublik: {$user->inline_lose}",

            parse_mode: ParseMode::HTML,
            reply_markup: $this->backKeyboard()
        );
    }

    public function statistic(Nutgram $bot)
    {
        $users = User::count();
        $game = Game::where('type', 'game')->value('count');
        $inline = Game::where('type', 'inline')->value('count');

        $bot->sendMessage(
            text: "📊 Statistika:

👤 Foydalanuvchilar: $users ta
🤖 Bot bilan o'yinlar: $game
👥 Do'stlar bilan o'yinlar: $inline",

            parse_mode: ParseMode::HTML,
            reply_markup: $this->backKeyboard()
        );
    }
}
