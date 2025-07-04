<?php
namespace Bot\Chats;

use App\Jobs\BulkMessageJob;
use App\Models\User;
use Bot\Keyboards\Keyboard;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Nutgram\Laravel\Facades\Telegram;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class BulkTypeChat extends Conversation
{
    use Keyboard;

    public $type;
    public $message_id;
    public $reply_markup;

    public $from_chat_id;
    public $progress_message_id;

    protected function getSerializableAttributes(): array
    {
        return [
            'type'                => $this->type,
            'message_id'          => $this->message_id,
            'reply_markup'        => $this->reply_markup,
            'from_chat_id'        => $this->from_chat_id,
            'progress_message_id' => $this->progress_message_id,
        ];
    }

    public function start(Nutgram $bot, $type)
    {
        $this->type = $type;

        editMessageText($bot, "Yuboriladigan xabarni kiriting:", 'html', $this->back_key());

        $this->next('message');
    }

    public function message(Nutgram $bot)
    {
        $this->from_chat_id = $bot->chatId();
        $this->message_id   = $bot->messageId();
        $this->reply_markup = $bot->message()->reply_markup;

        sendMessage($bot, "Xabar yuborishni boshlash uchun quyidagi tugmadan foydalaning:", 'html', $this->bulkstart_key());

        $this->next('bulk_start');
    }

    public function bulk_start(Nutgram $bot)
    {
        $from_chat_id = $this->from_chat_id;
        $message_id   = $this->message_id;
        $reply_markup = $this->reply_markup;
        $type         = $this->type;

        $bot->message()->delete();

        $info = sendMessage($bot, "Xabar yuborish boshlanmoqda, iltimos ushbu xabarni o'chirmang!");

        cache()->put('chat_id', $this->from_chat_id);
        cache()->put('message_id', $info->message_id);

        sendMessage($bot, "Xabar yuborish boshlandi", 'html', $this->back_key());

        User::lazy()->each(function ($users) use ($from_chat_id, $message_id, $reply_markup, $type) {
            $batches = $users->map(function ($user) use ($from_chat_id, $message_id, $reply_markup, $type) {
                return new BulkMessageJob($user->user_id, $from_chat_id, $message_id, $reply_markup, $type);
            });

            Bus::batch($batches)
                ->progress(function (Batch $batch) {
                    $count_sent   = $batch->totalJobs - $batch->pendingJobs - $batch->failedJobs;
                    $count_failed = $batch->failedJobs;

                    $chat_id    = cache('chat_id');
                    $message_id = cache('message_id');

                    if ($batch->processedJobs() % 100 === 0) {
                        Telegram::editMessageText(
                            "✅ Yuborildi: {$count_sent}\n❌ Yuborilmadi: {$count_failed}\n\n🔸Jami: " . ($count_sent + $count_failed),
                            $chat_id,
                            $message_id
                        );
                    }
                })
                ->finally(function (Batch $batch) {
                    $count_sent   = $batch->totalJobs - $batch->pendingJobs - $batch->failedJobs;
                    $count_failed = $batch->failedJobs;

                    $chat_id    = cache('chat_id');
                    $message_id = cache('message_id');

                    Telegram::editMessageText(
                        "🏁Xabar yuborish yakunlandi!\n\n✅ Yuborildi: {$count_sent}\n❌ Yuborilmadi: {$count_failed}\n\n🔸Jami: " . ($count_sent + $count_failed),
                        $chat_id,
                        $message_id
                    );

                    cache()->forget('chat_id');
                    cache()->forget('message_id');
                })
                ->dispatch();
        });

        $this->end();
    }
}
