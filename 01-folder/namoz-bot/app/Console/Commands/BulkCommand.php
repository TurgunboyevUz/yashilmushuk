<?php

namespace App\Console\Commands;

use App\Models\Bulk;
use App\Models\User;
use Illuminate\Console\Command;
use Nutgram\Laravel\Facades\Telegram;

class BulkCommand extends Command
{
    protected $signature = 'app:bulk';

    protected $description = 'Foydalanuvchilarga xabar yuborish.';

    public function handle()
    {
        $bulk = Bulk::where('is_done', 0)->first();

        if (!$bulk) return $this->info("Hozirda aktiv xabar yuborish mavjud emas!");

        return $this->bulk($bulk);
    }

    public function bulk(&$bulk)
    {
        $limit = 100;
        $offset = $bulk->success + $bulk->failed;

        $users = User::limit($limit)->offset($offset)->get();

        if($users->isEmpty()) {
            $bulk->update(['is_done' => 1]);
            
            Telegram::sendMessage("Xabar yuborish tugadi.\n{$bulk->success} ta foydalanuvchiga xabar yuborildi\n{$bulk->failed} ta foydalanuvchiga xabar yuborilmadi.", $bulk->chat_id);

            return $this->info("Xabar yuborish tugadi.\n{$bulk->success} ta foydalanuvchiga xabar yuborildi\n{$bulk->failed} ta foydalanuvchiga xabar yuborilmadi.");
        }

        if($bulk->type == 1) {
            $users->each(function ($user) use (&$bulk) {
                if($this->copyMessage($user->user_id, $bulk->chat_id, $bulk->message_id, unserialize($bulk->reply_markup))) {
                    $bulk->success++;
                }else{
                    $user->delete();
                    $bulk->failed++;
                }
            });
        }else{
            $users->each(function ($user) use (&$bulk) {
                if($this->forwardMessage($user->user_id, $bulk->chat_id, $bulk->message_id)) {
                    $bulk->success++;
                }else{
                    $user->delete();
                    $bulk->failed++;
                }
            });
        }

        $bulk->save();

        $this->info("{$bulk->success} ta foydalanuvchiga xabar yuborildi.\n{$bulk->failed} ta foydalanuvchiga xabar yuborilmadi.");
    }

    public function copyMessage($chat_id, $from_chat_id, $message_id, $reply_markup = null)
    {
        try {
            Telegram::copyMessage(...compact('chat_id', 'from_chat_id', 'message_id', 'reply_markup'));

            return true;
        }catch (\Throwable $th) {
            return false;
        }
    }

    public function forwardMessage($chat_id, $from_chat_id, $message_id)
    {
        try {
            Telegram::forwardMessage(...compact('chat_id', 'from_chat_id', 'message_id'));
            return true;
        }catch (\Throwable $th) {
            return false;
        }
    }
}