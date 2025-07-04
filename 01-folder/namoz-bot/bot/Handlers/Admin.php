<?php

namespace Bot\Handlers;

use App\Models\Bulk;
use App\Models\Channel;
use App\Models\User;
use Bot\Keyboards\Dashboard;
use SergiX44\Nutgram\Nutgram;

class Admin
{
    use Dashboard;

    public function dashboard(Nutgram $bot)
    {
        sendMessage($bot, "Boshqaruv paneliga xush kelibsiz!" . PHP_EOL . PHP_EOL . "Foydalanuvchilar soni: " . User::count(), 'html', $this->main_key());
    }

    public function main(Nutgram $bot)
    {
        $bot->endConversation();

        editMessageText($bot, "Boshqaruv paneliga xush kelibsiz!" . PHP_EOL . PHP_EOL . "Foydalanuvchilar soni: " . User::count(), 'html', $this->main_key());
    }

    public function channel_manager(Nutgram $bot)
    {
        editMessageText($bot, "Quyida kanallar ro'yxati:", 'html', $this->channels_key());
    }

    public function delete_channel(Nutgram $bot, $id)
    {
        Channel::where('id', $id)->delete();

        editMessageText($bot, "Kanal muvaffaqiyatli o'chirildi!", 'html', $this->back_key());
    }

    public function update(Nutgram $bot, $id)
    {
        $bulk = Bulk::find($id);

        if (!$bulk->is_done) {
            editMessageText($bot, "Xabar yuborish jarayoni davom etmoqda.\n\nYuborildi: {$bulk->success}\n\nYuborilmadi: {$bulk->failed}\n\nYuborish jarayonini ko'rib borish uchun quyidagi tugmadan foydalaning:", 'html', $this->update_key($id));
        }else{
            answerCallbackQuery($bot, "Ushbu xabarning yuborilish jarayoni yakunlangan", true);
            
            deleteMessage($bot);
            sendMessage($bot, "Yuborildi: {$bulk->success}\nYuborilmadi: {$bulk->failed}", 'html', $this->back_key());
        }
    }
}