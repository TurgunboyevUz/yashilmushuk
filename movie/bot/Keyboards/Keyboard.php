<?php
namespace Bot\Keyboards;

use App\Models\Forum;
use App\Models\Movie;

trait Keyboard
{
    public function main_key()
    {
        $count = Forum::count();

        return inlineKeyboard([
            [['text' => "➕ Kino qo'shish", 'callback_data' => 'add_movie'], ['text' => "➕ Serial qo'shish", 'callback_data' => 'add_serial']],
            ['text' => "🔊 Kanallar ({$count})", 'callback_data' => 'forums'],
            ['text' => '📊 Statistika', 'callback_data' => 'chart'],
            ['text' => '✉️ Xabar yuborish', 'callback_data' => 'bulk'],
        ]);
    }

    public function back_key()
    {
        return inlineKeyboard([
            ['text' => '🔙 Orqaga', 'callback_data' => 'back'],
        ]);
    }

    public function forums_key()
    {
        $forums = Forum::all();

        return inlineKeyboard($forums->map(function ($forum) {
            $link = $forum->by_username ? "https://t.me/{$forum->username}" : $forum->link;

            return [
                ['text' => $forum->title, 'url' => $link],
                ['text' => '✏️', 'callback_data' => "edit_forum_{$forum->id}"],
                ['text' => '❌', 'callback_data' => "delete_forum_{$forum->id}"],
            ];
        })->push(['text' => '➕ Kanal qo\'shish', 'callback_data' => 'add_forum'])
            ->push(['text' => '🔙 Orqaga', 'callback_data' => 'back'])->toArray());
    }

    public function add_forum_key()
    {
        return inlineKeyboard([
            [
                ['text' => '🔵 Telegram', 'callback_data' => 'add_tele_forum'],
                ['text' => '🔴 Boshqa', 'callback_data' => 'add_other_forum'],
            ],
            ['text' => '🔙 Orqaga', 'callback_data' => 'back'],
        ]);
    }

    public function edit_forum_key($forum)
    {
        return inlineKeyboard([
            ['text' => '🔄 Yangilash', 'callback_data' => "update_forum_{$forum->id}"],
            ['text' => '✏️ Havolani o\'zgartirish', 'callback_data' => "link_forum_{$forum->id}"],
            ['text' => 'Tugma: ' . ($forum->by_username ? "©️" : "🔗"), 'callback_data' => "type_forum_{$forum->id}"],
            ['text' => 'Zayavka: ' . ($forum->invitable ? "🟢" : "🔴"), 'callback_data' => "invite_forum_{$forum->id}"],
            ['text' => '🔙 Orqaga', 'callback_data' => 'back'],
        ]);
    }

    public function finish_serial_key()
    {
        return inlineKeyboard([
            ['text' => '✔️ Tugatish', 'callback_data' => 'finish'],
            ['text' => '🔙 Orqaga', 'callback_data' => 'back'],
        ]);
    }

    public function subscribe_key($forums)
    {
        return inlineKeyboard($forums->map(function ($forum) {
            $link = $forum->by_username ? "https://t.me/{$forum->username}" : $forum->link;

            return [
                ['text' => $forum->title, 'url' => $link],
            ];
        })->push(['text' => '✅ Tekshirish', 'callback_data' => 'subscribe'])->toArray());
    }

    public function serials_page_key($movie, $page = 1)
    {
        $perPage = 10;
        $offset  = ($page - 1) * $perPage;

        $serials = $movie->serials()->limit($perPage)->offset($offset)->get();

        if ($page == 0 or ceil($movie->serials()->count() / $perPage) < $page) {
            return;
        }

        $keyboard = [];
        $row      = [];

        foreach ($serials as $index => $serial) {
            $number = $offset + $index + 1;

            $row[] = ['text' => $number . ($index == 0 ? ' - 💽' : ''), 'callback_data' => "serial_{$number}_{$serial->id}"];

            if (($index + 1) % 3 == 0) {
                $keyboard[] = $row;
                $row        = [];
            }
        }

        if ($row) {
            $keyboard[] = $row;
        }

        $keyboard[] = [
            ['text' => '⬅️', 'callback_data' => 'page_' . ($movie->id) . '_' . ($page - 1)],
            ['text' => '❌', 'callback_data' => 'remove'],
            ['text' => '➡️', 'callback_data' => 'page_' . ($movie->id) . '_' . ($page + 1)],
        ];

        return inlineKeyboard($keyboard);
    }

    public function serials_choose_key($chosen_serial, $index = 1)
    {
        $perPage = 10;

        $page   = ceil($index / $perPage);
        $offset = ($page - 1) * $perPage;

        $serials = $chosen_serial->movie->serials()->limit($perPage)->offset($offset)->get();

        $keyboard = [];
        $row      = [];

        foreach ($serials as $index => $serial) {
            $number = $offset + $index + 1;

            $row[] = ['text' => $number . ($serial->id == $chosen_serial->id ? ' - 💽' : ''), 'callback_data' => "serial_{$number}_{$serial->id}"];

            if (($index + 1) % 3 == 0) {
                $keyboard[] = $row;
                $row        = [];
            }
        }

        if ($row) {
            $keyboard[] = $row;
        }

        $keyboard[] = [
            ['text' => '⬅️', 'callback_data' => 'page_' . ($chosen_serial->movie->id) . '_' . ($page - 1)],
            ['text' => '❌', 'callback_data' => 'remove'],
            ['text' => '➡️', 'callback_data' => 'page_' . ($chosen_serial->movie->id) . '_' . ($page + 1)],
        ];

        return inlineKeyboard($keyboard);
    }

    public function submovie_key($code)
    {
        return inlineKeyboard([
            [['text' => "🍿 Boshqa filmlar", 'url' => config('nutgram.admin_url')], ['text' => "👨‍💻 Admin", 'url' => config('nutgram.other_movies')]],
            ['text' => '↗️ Ulashish', 'url' => "https://t.me/share/url?url=https://t.me/" . config('nutgram.username') . "?start={$code}"],
            ['text' => "🔸 Instagram", 'url' => config('nutgram.instagram_url')],
        ]);
    }

    public function bulktype_key()
    {
        return inlineKeyboard([
            ['text' => '✉️ Oddiy xabar', 'callback_data' => 'bulk_copy'],
            ['text' => '📧 Forward xabar', 'callback_data' => 'bulk_forward'],
            ['text' => '🔙 Orqaga', 'callback_data' => 'back']
        ]);
    }

    public function bulkstart_key()
    {
        return inlineKeyboard([
            ['text' => '🏳️ Boshlash', 'callback_data' => 'start_bulking'],
            ['text' => '🔙 Orqaga', 'callback_data' => 'back']
        ]);
    }
}
