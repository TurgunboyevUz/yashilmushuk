<?php

namespace Bot\Chats;

use App\Models\Bulk;
use Bot\Keyboards\Dashboard;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class BulkMessage extends Conversation
{
    use Dashboard;

    public $chat_id;
    public $message_id;
    public $reply_markup;

    protected function getSerializableAttributes(): array
    {
        return [
            'chat_id' => (int) $this->chat_id,
            'message_id' => (int) $this->message_id,
            'reply_markup' => $this->reply_markup,
        ];
    }

    public function start(Nutgram $bot)
    {
        if (Bulk::where('is_done', true)->exists()) {
            editMessageText($bot, "Hozirda boshqa xabar yuborish jarayoni davom etmoqda, iltimos xabar yuborish jarayoni tugallanishini kuting!", 'html', $this->back_key());
        }

        editMessageText($bot, "Foydalanuvchilarga yuborilishi kerak bo'lgan xabarni yuboring:", 'html', $this->back_key());

        $this->next('message');
    }

    public function message(Nutgram $bot)
    {
        $this->chat_id = $bot->chatId();
        $this->message_id = $bot->messageId();
        $this->reply_markup = $bot->message()->reply_markup;

        sendMessage($bot, "Xabarning qaysi usulda yuborish kerakligini tanlang, eslatma: xabar yuborish turini tanlashingiz bilan xabar yuborish boshlanadi.", 'html', $this->bulk_key());

        $this->next('type');
    }

    public function type(Nutgram $bot)
    {
        $ex = explode('/', $bot->callbackQuery()->data);

        if ($ex[1] == 'simple') {
            $type = 1;
        }

        if ($ex[1] == 'forward') {
            $type = 2;
        }

        $bulk = Bulk::create([
            'type' => $type,
            'chat_id' => $this->chat_id,
            'message_id' => $this->message_id,
            'reply_markup' => serialize($this->reply_markup),
        ]);

        editMessageText($bot, "Xabar yuborishi boshlandi, xabar yuborish jarayonini ko'rib borish uchun quyidagi tugmadan foydalaning:", 'html', $this->update_key($bulk->id));

        $this->end();
    }
}
