<?php declare(strict_types=1);

use danog\MadelineProto\SimpleEventHandler;
use Amp\Promise;
use function Amp\call;

class UserEventHandler extends SimpleEventHandler
{
    protected string $card       = '9860340101171437';
    protected string $channel_id = '-1002246767554';

    private int $queue    = 0;
    private int $count    = 0;
    private int $group_id = 0;
    private int $post_id  = 0;
    private bool $label   = false;

    private function attempt1(array $message, int $post_id, int $group_id): Promise
    {
        return call(function () use ($message, $post_id, $group_id): void {
            if (preg_match('/\b(\d+)(?:\s*-\s*(?:karta|yozgan|komment|comment))?\b/i', $message['message'], $matches)) {
                $this->queue    = (int) $matches[1];
                $this->count    = 0;
                $this->group_id = $group_id;
                $this->post_id  = $post_id;
                $this->label    = true;
            }
        });
    }

    private function handle_attempt1(int $message_id, int $group_id): Promise
    {
        return call(function () use ($message_id, $group_id): void {
            if (++$this->count === $this->queue) {
                yield $this->sendMessage($group_id, $this->card, ['reply_to_msg_id' => $message_id]);
            }
        });
    }

    public function onUpdateNewChannelMessage(array $update): Promise
    {
        return call(function () use ($update): void {
            $message    = $update['message'];
            $peer_id    = $message['peer_id'];
            $message_id = $message['id'];

            if ($message['fwd_from']['from_id'] ?? '' === $this->channel_id) {
                yield $this->attempt1($message, $message_id, $peer_id);
                return;
            }

            if (! $this->label || ! isset($message['reply_to'])) {
                return;
            }

            $reply_to_msg_id = $message['reply_to']['reply_to_msg_id'] ?? $message['reply_to']['reply_to_top_id'];

            // Validate the reply belongs to the tracked message
            if ($this->post_id === $reply_to_msg_id && $this->group_id === $peer_id) {
                yield $this->handle_attempt1($reply_to_msg_id, $peer_id);
            }
        });
    }
}
