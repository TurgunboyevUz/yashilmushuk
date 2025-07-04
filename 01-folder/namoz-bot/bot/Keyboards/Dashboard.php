<?php

namespace Bot\Keyboards;

use App\Models\Channel;

trait Dashboard
{
    public function main_key()
    {
        return inlineKeyboard([
            ['text' => "Xabar yuborish", 'callback_data' => 'send-message'],
            ['text' => "Kanal boshqaruvi", 'callback_data' => 'channel-manager']
        ]);
    }

    public function back_key()
    {
        return inlineKeyboard([
            ['text' => "Orqaga", 'callback_data' => 'main']
        ]);
    }

    public function channels_key()
    {
        $list = Channel::all();
        $count = count($list);

        $arr = [];

        foreach ($list as $item) {
            $arr[] = [
                ['text' => $item->title, 'url' => $item->url],
                ['text' => "❌", 'callback_data' => 'delete/' . $item->id],
            ];
        }

        if($count < 5){
            $arr[] = ['text' => "Kanal qo'shish", 'callback_data' => 'create-channel'];
        }

        $arr[] = ['text' => "Orqaga", 'callback_data' => 'main'];

        return inlineKeyboard($arr);
    }

    public function type_key()
    {
        return inlineKeyboard([
            ['text' => 'Oddiy kanal', 'callback_data' => 'channel-type/simple'],
            ['text' => 'Zayavka kanal', 'callback_data' => 'channel-type/requested'],
            ['text' => 'Orqaga', 'callback_data' => 'main']
        ]);
    }

    public function bulk_key()
    {
        return inlineKeyboard([
            ['text' => 'Oddiy xabar', 'callback_data' => 'message-type/simple'],
            ['text' => 'Forward', 'callback_data' => 'message-type/forward'],
            ['text' => 'Orqaga', 'callback_data' => 'main']
        ]);
    }

    public function update_key($id)
    {
        return inlineKeyboard([
            ['text' => "Yangilash", 'callback_data' => 'update/' . $id],
        ]);
    }
}