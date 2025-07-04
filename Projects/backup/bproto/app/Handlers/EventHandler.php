<?php declare (strict_types = 1);

namespace App\Handlers;

use danog\MadelineProto\SimpleEventHandler;
use Illuminate\Support\Facades\Log;

class EventHandler extends SimpleEventHandler
{
    protected string $card       = '9860340101171437';
    protected string $channel_id = '-1002246767554';

    private int $queue    = 0;
    private int $count    = 0;
    private int $group_id = 0;
    private int $post_id  = 0;
    private bool $label   = false;

    private function attempt1(array $message, int $post_id, int $group_id): void
    {
        if (preg_match('/\b(\d+)(?:\s*-\s*(?:karta|yozgan|komment|comment))?\b/i', $message['message'], $matches)) {
            $this->queue    = (int) $matches[1];
            $this->count    = 0;
            $this->group_id = $group_id;
            $this->post_id  = $post_id;
            $this->label    = true;
        }
    }

    private function handle_attempt1(int $message_id, int $group_id): void
    {
        if (++$this->count === $this->queue) {
            $this->sendMessage($group_id, $this->card, replyToMsgId: $message_id);
        }
    }

    public function onUpdateNewChannelMessage(array $update): void
    {
        $message    = $update['message'];
        $peer_id    = $message['peer_id'];
        $message_id = $message['id'];

        if ($message['fwd_from']['from_id'] ?? '' === $this->channel_id) {
            $this->attempt1($message, $message_id, $peer_id);
            return;
        }

        if (! $this->label || ! isset($message['reply_to'])) {
            return;
        }

        $message_id = $message['reply_to']['reply_to_msg_id'] ?? $message['reply_to']['reply_to_top_id'];

        // Validate the reply belongs to the tracked message
        if ($this->post_id === $message_id && $this->group_id === $peer_id) {
            $this->handle_attempt1($message_id, $peer_id);
        }
    }

    public function onAny(array $update)
    {
        Log::channel('stderr')->info('Data:', $update);
    }
}
