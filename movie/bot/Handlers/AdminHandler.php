<?php

namespace Bot\Handlers;

use App\Models\Forum;
use App\Models\Movie;
use App\Models\User;
use Bot\Keyboards\Keyboard;
use SergiX44\Nutgram\Nutgram;

class AdminHandler
{
    use Keyboard;

    public function dash(Nutgram $bot)
    {
        $bot->endConversation();

        sendMessage($bot, 'Admin panel', 'html', $this->main_key());
    }

    public function back(Nutgram $bot)
    {
        $bot->endConversation();

        editMessageText($bot, 'Admin panel', 'html', $this->main_key());
    }

    public function del(Nutgram $bot, $id)
    {
        $movie = Movie::find($id);

        if($movie) {
            $movie->delete();

            sendMessage($bot, 'Kino bazadan muvaffaqiyatli o\'chirildi', 'html', $this->main_key());
        }else{
            sendMessage($bot, 'Kino topilmadi', 'html', $this->main_key());
        }
    }

    public function forums(Nutgram $bot)
    {
        editMessageText($bot, 'Kanallar', 'html', $this->forums_key());
    }

    public function add_forum(Nutgram $bot)
    {
        editMessageText($bot, 'Kanal qo\'shish', 'html', $this->add_forum_key());
    }

    public function edit_forum(Nutgram $bot, $id)
    {
        $forum = Forum::find($id);

        if($forum) {
            editMessageText($bot, 'Kanal tahrirlash', 'html', $this->edit_forum_key($forum));
        }else{
            editMessageText($bot, 'Kanal topilmadi', 'html', $this->forums_key());
        }
    }

    public function update_forum(Nutgram $bot, $id)
    {
        $forum = Forum::find($id);

        if(!$forum) {
            return editMessageText($bot, 'Kanal topilmadi', 'html', $this->forums_key());
        }

        if(!$forum->is_telegram) {
            return answerCallbackQuery($bot, 'Ushbu kanal uchun bu funksiya mavjud emas!', true);
        }

        $chat = getChat($bot, $forum->tele_id);

        $title = $chat->title;
        $username = $chat->username;
        $invite_link = $chat->invite_link;

        $forum->update([
            'title' => $title,
            'username' => $username,
            'link' => $invite_link,

            'by_username' => !is_null($username),
        ]);

        editMessageText($bot, 'Kanal ma\'lumotlari yangilandi', 'html', $this->edit_forum_key($forum));
    }

    public function type_forum(Nutgram $bot, $id)
    {
        $forum = Forum::find($id);

        if(!$forum) {
            return editMessageText($bot, 'Kanal topilmadi', 'html', $this->forums_key());
        }

        if(!$forum->is_telegram) {
            return answerCallbackQuery($bot, 'Ushbu kanal uchun bu funksiya mavjud emas!', true);
        }

        if(empty($forum->username)) {
            $forum->update([
                'by_username' => false,
            ]);
        }else{
            $forum->update([
                'by_username' => !$forum->by_username,
            ]);
        }

        editMessageText($bot, 'Kanal turi o\'zgartirildi', 'html', $this->edit_forum_key($forum));
    }

    public function invite_forum(Nutgram $bot, $id)
    {
        $forum = Forum::find($id);

        if(!$forum) {
            return editMessageText($bot, 'Kanal topilmadi', 'html', $this->forums_key());
        }

        if(!$forum->is_telegram) {
            return answerCallbackQuery($bot, 'Ushbu kanal uchun bu funksiya mavjud emas!', true);
        }

        $forum->update([
            'invitable' => !$forum->invitable,
        ]);

        editMessageText($bot, 'Zayavka turi o\'zgartirildi', 'html', $this->edit_forum_key($forum));
    }

    public function delete_forum(Nutgram $bot, $id)
    {
        $forum = Forum::find($id);

        if($forum) {
            $forum->delete();

            editMessageText($bot, 'Kanal o\'chirildi', 'html', $this->forums_key());
        }else{
            editMessageText($bot, 'Kanal topilmadi', 'html', $this->forums_key());
        }
    }

    public function chart(Nutgram $bot)
    {
        $count = User::count();
        $today = User::where('created_at', '>=', now()->subDay())->count();

        editMessageText($bot, "📊 Foydalanuvchilar soni: {$count}\n\n🔹 Bugun ro'yxatdan o'tdi: {$today}", 'html', $this->back_key());
    }

    public function add_admin(Nutgram $bot, $id)
    {
        $user = User::where('user_id', $id)->first();

        if($user) {
            $user->update([
                'is_admin' => true,
            ]);

            sendMessage($bot, "Admin ro'yxatiga muvaffaqiyatli qo'shildi.", 'html');
        }else{
            sendMessage($bot, "Foydalanuvchi topilmadi.", 'html');
        }
    }

    public function del_admin(Nutgram $bot, $id)
    {
        $user = User::where('user_id', $id)->first();

        if($user) {
            $user->update([
                'is_admin' => false,
            ]);

            sendMessage($bot, "Admin ro'yxatidan o'chirildi.", 'html');
        }else{
            sendMessage($bot, "Foydalanuvchi topilmadi.", 'html');
        }
    }

    public function bulk(Nutgram $bot)
    {
        editMessageText($bot, "Yuboriladigan xabar turini tanlang:", 'html', $this->bulktype_key());
    }
}
