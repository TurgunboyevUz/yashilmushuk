<?php declare (strict_types = 1);

use danog\MadelineProto\SimpleEventHandler;

class UserHandler extends SimpleEventHandler
{
    public function onUpdateNewChannelMessage(array $update): void
    {
        $message = $update['message'];

        $fwd_from = $message['fwd_from']['from_id'] ?? '';
        if ($fwd_from != '-1002246767554') {
            return;
        }

        if ($message['message'] != 'karta') {
            return;
        }

        $this->sendMessage($message['peer_id'], '9860340101171437', replyToMsgId: $message['id']);
    }
}
