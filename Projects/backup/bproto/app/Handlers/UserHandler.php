<?php declare (strict_types = 1);
namespace App\Handlers;

use danog\MadelineProto\SimpleEventHandler;

class UserHandler extends SimpleEventHandler
{
    private string $channel_id = '-1002246767554';
    private string $card = '9860340101171437';

    public function onUpdateNewChannelMessage(array $update): void
    {
        //print_r($update);

        $message    = $update['message'];
        $peer_id    = $message['peer_id'];                   // guruh ID
        $fwd_from   = $message['fwd_from']['from_id'] ?? ''; // kanal ID
        $message_id = $message['id'];                        // xabar ID

        if ($fwd_from == $this->channel_id && $message['message'] == 'karta') {
            $this->sendMessage($peer_id, $this->card, replyToMsgId: $message_id);
        }
    }
}
