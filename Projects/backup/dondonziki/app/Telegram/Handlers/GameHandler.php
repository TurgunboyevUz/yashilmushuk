<?php

namespace App\Telegram\Handlers;

use App\Models\Game;
use App\Traits\UserTrait;
use Illuminate\Support\Facades\Log;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton as Button;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup as Markup;

class GameHandler
{
    use UserTrait;

    public function new (Nutgram $bot)
    {
        $bot->answerInlineQuery([
            [
                'type' => "article",
                'id' => $bot->inlineQuery()->from->id,
                'title' => "Yangi o'yin",
                'input_message_content' => [
                    'message_text' => "<b>Tosh-Qaychi-Qog'oz</b>",
                    'parse_mode' => 'html',
                ],
                'reply_markup' => [
                    'inline_keyboard' => [
                        [
                            ['text' => '✊', 'callback_data' => 'inline_1'],
                            ['text' => '✌', 'callback_data' => 'inline_2'],
                            ['text' => '✋', 'callback_data' => 'inline_3'],
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function game(Nutgram $bot)
    {
        $buttons = Markup::make();

        $buttons->addRow(
            Button::make(text: "✊", callback_data: 'move_1'),
            Button::make(text: "✌", callback_data: 'move_2'),
            Button::make(text: "✋", callback_data: 'move_3'),
        );

        $buttons->addRow(
            Button::make(text: "🔙 Orqaga", callback_data: 'back')
        );

        $bot->editMessageText(
            text: "Quyidagi tugmalardan birini tanlang:",
            parse_mode: ParseMode::HTML,
            reply_markup: $buttons
        );
    }

    public function move(Nutgram $bot, $move)
    {
        $mode = $this->user()->mode ?? 1;

        if ($mode == 1) {
            $move2 = rand(1, 3);
        }

        if ($mode == 2) {
            $moves = [
                1 => [3, 3, 3, 1, 1, 2],
                2 => [1, 1, 1, 2, 2, 3],
                3 => [2, 2, 2, 3, 3, 1],
            ];

            $move2 = $moves[$move][rand(0, 5)];
        }

        $buttons = Markup::make();

        $buttons->addRow(
            Button::make(text: "🔁 Qayta urinish", callback_data: 'game')
        );

        $buttons->addRow(
            Button::make(text: "🔙 Orqaga", callback_data: 'back')
        );

        $user_move = config('nutgram.stickers.' . $move);
        $bot_move = config('nutgram.stickers.' . $move2);

        Game::game();

        if ($move == $move2) {
            $this->draw($bot->chatId());

            $bot->editMessageText(
                text: "🤝 Durrang, yana bir bor urinib ko'ring!\nSiz: $user_move\nBot: $bot_move",
                parse_mode: ParseMode::HTML,
                reply_markup: $buttons
            );
        }

        if (($move == 1 && $move2 == 2) || ($move == 2 && $move2 == 3) || ($move == 3 && $move2 == 1)) {
            $this->win($bot->chatId());

            $bot->editMessageText(
                text: "Yutdingiz, tabriklaymiz!\nSiz: $user_move\nBot: $bot_move",
                parse_mode: ParseMode::HTML,
                reply_markup: $buttons
            );
        }

        if (($move == 1 && $move2 == 3) || ($move == 2 && $move2 == 1) || ($move == 3 && $move2 == 2)) {
            $this->lose($bot->chatId());

            $bot->editMessageText(
                text: "Yutqazdingiz, yana bir bor urinib ko'ring!\nSiz: $user_move\nBot: $bot_move",
                parse_mode: ParseMode::HTML,
                reply_markup: $buttons
            );
        }
    }

    public function inline(Nutgram $bot, $move)
    {
        $id = $bot->inlineMessageId();
        $name = $bot->callbackQuery()->from->first_name;
        $from_id = $bot->callbackQuery()->from->id;

        if ($this->has($id)) {
            $game = $this->get($id);

            if ($game['id'] == $from_id) {
                $bot->answerCallbackQuery(
                    text: "Tanlov qilib bo'lgansiz, qarshi tomon javobini kuting!",
                    show_alert: true
                );

                return;
            }

            $this->delete($id);
            Game::inline();

            $move1 = config('nutgram.stickers.' . $game['move']);
            $move2 = config('nutgram.stickers.' . $move);

            if ($game['move'] == $move) {
                $this->inlineDraw($from_id);
                $this->inlineDraw($game['id']);

                $bot->editMessageText(
                    text: "Durrang!🤝
<a href='tg://user?id={$game['id']}'>{$game['name']}</a>: {$move1}
<a href='tg://user?id={$from_id}'>{$name}</a>: $move2" . config('nutgram.reklama'),
                    parse_mode: ParseMode::HTML,
                    disable_web_page_preview: true
                );
            }

            if (
                ($move == 1 && $game['move'] == 2) ||
                ($move == 2 && $game['move'] == 3) ||
                ($move == 3 && $game['move'] == 1)
            ) {
                $this->inlineWin($from_id);
                $this->inlineLose($game['id']);

                $str = "<a href='tg://user?id={$game['id']}'>{$game['name']}</a>: {$move1}";
                $str .= "\n<a href='tg://user?id={$from_id}'>{$name}</a>: $move2";
                $str .= "\nG'olib: $name 🏆🎉" . config('nutgram.reklama');

                $bot->editMessageText(
                    text: $str,
                    parse_mode: ParseMode::HTML,
                    disable_web_page_preview: true
                );
            }

            if (
                ($move == 1 && $game['move'] == 3) ||
                ($move == 2 && $game['move'] == 1) ||
                ($move == 3 && $game['move'] == 2)
            ) {
                $this->inlineLose($from_id);
                $this->inlineWin($game['id']);

                $str = "<a href='tg://user?id={$game['id']}'>{$game['name']}</a>: {$move1}";
                $str .= "\n<a href='tg://user?id={$from_id}'>{$name}</a>: $move2";
                $str .= "\nG'olib: {$game['name']} 🏆🎉" . config('nutgram.reklama');

                $bot->editMessageText(
                    text: $str,
                    parse_mode: ParseMode::HTML,
                    disable_web_page_preview: true
                );
            }
        } else {
            $this->save($id, [
                'id' => $from_id,
                'name' => $name,
                'move' => $move,
            ]);

            $bot->answerCallbackQuery(
                text: "Tanlovingiz qabul qilindi, qarshi tomon javobini kuting!",
                show_alert: false
            );
        }
    }
}
