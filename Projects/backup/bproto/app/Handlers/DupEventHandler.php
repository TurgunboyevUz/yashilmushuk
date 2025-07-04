<?php declare (strict_types = 1);

namespace App\Handlers;

use danog\MadelineProto\SimpleEventHandler;

use function Laravel\Prompts\info;

class DupEventHandler extends SimpleEventHandler
{
    protected string $card        = '9860340101171437';
    protected string $channel_id = '-1002246767554';

    protected int $queue = 0;
    protected int $count = 0;

    protected int $group_id = 0;
    protected int $post_id = 0;

    protected bool $label = false;

    private function attempt1($message, $post_id, $group_id)
    { // n - kartaga yutuq bittada
        $text = $message['message'] ?? '';

        if (preg_match('/\b(\d+)(?:\s*-\s*(?:karta|yozgan|komment|comment))?\b/i', $text, $matches)) {
            $this->queue = (int) $matches[1];
            $this->count = 0;
            $this->group_id = $group_id;
            $this->post_id = $post_id;
            $this->label = true;

            info('TUTDIM!');
        }
    }

    private function handle_attempt1($message_id, $group_id)
    {
        $this->count++;

        if($this->queue - 1 == $this->count){
            $this->sendMessage($group_id, $this->card, replyToMsgId: $message_id);
        }
    }

    /*public function onAny(array $update)
    {
        if ($update['_'] == 'updateChatDefaultBannedRights') {
            if ($update['default_banned_rights']['send_messages'] == 0) {
                $this->sendMessage($update['peer'], "Astral sho'tta");
            }
        }
    }*/

    public function onUpdateNewChannelMessage(array $update)
    {
        //print_r($update);

        $message    = $update['message'];
        $peer_id    = $message['peer_id'];                   // guruh ID
        $fwd_from   = $message['fwd_from']['from_id'] ?? ''; // kanal ID
        $message_id = $message['id'];                        // xabar ID

        if ($fwd_from == $this->channel_id) {
            return $this->attempt1($message, $message_id, $peer_id);
        }

        if($this->label == true && isset($message['reply_to'])){
            $message_id = $message['reply_to']['reply_to_msg_id'] ?? $message['reply_to']['reply_to_top_id'];
            $peer_id = $message['peer_id'];

            if($this->post_id == $message_id && $this->group_id == $peer_id){
                return $this->handle_attempt1($message_id, $peer_id);
            }
        }

        /*if ($has_label) {
            $post_id = $message['id'];
            $message = $update['message'];
            preg_match_all('/\d+\.?\d', $message, $matches);

            if ($matches) {
                $peer_id    = $message['peer_id'];
                $fwd_from   = $message['fwd_from']['from_id'] ?? '';
                $message_id = $message['id'];

                if (in_array($fwd_from, $this->channel_list)) {
                    $this->sendMessage($peer_id, $this->card, replyToMsgId: $message_id);
                }
            }
        }*/
    }
}
