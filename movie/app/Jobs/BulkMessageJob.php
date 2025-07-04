<?php
namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Nutgram\Laravel\Facades\Telegram;

class BulkMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $chat_id;
    public $from_chat_id;
    public $message_id;
    public $reply_markup;
    public $type;

    /**
     * Create a new job instance.
     */
    public function __construct($chat_id, $from_chat_id, $message_id, $reply_markup, $type)
    {
        $this->chat_id      = $chat_id;
        $this->from_chat_id = $from_chat_id;
        $this->message_id   = $message_id;
        $this->reply_markup = $reply_markup;
        $this->type         = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->type == 'copy') {
            Telegram::copyMessage($this->chat_id, $this->from_chat_id, $this->message_id, reply_markup: $this->reply_markup);
        } else {
            Telegram::forwardMessage($this->chat_id, $this->from_chat_id, $this->message_id);
        }
    }
}
