<?php

namespace Bot\Chats;

use App\Models\Forum;
use Bot\Keyboards\Keyboard;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class LinkForumChat extends Conversation
{
    use Keyboard;

    public $id;

    protected function getSerializableAttributes(): array
    {
        return [
            'id' => $this->id
        ];
    }

    public function start(Nutgram $bot, $id)
    {
        $this->id = $id;

        editMessageText($bot, "Kanal uchun havola kiriting:", 'html', $this->back_key());

        $this->next('link');
    }

    public function link(Nutgram $bot)
    {
        $text = $bot->message()->text;

        if(str_starts_with($text, 'https://') or str_starts_with($text, 'http://')) {
            $forum = Forum::find($this->id);

            if($forum) {
                $forum->update([
                    'link' => $text,
                ]);

                sendMessage($bot, "Havola muvaffaqiyatli o'zgartirildi.", 'html', $this->forums_key());
            }else{
                sendMessage($bot, "Kanal topilmadi.", 'html', $this->forums_key());
            }

            $this->end();
        }
    }
}