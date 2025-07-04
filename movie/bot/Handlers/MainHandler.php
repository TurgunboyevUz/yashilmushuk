<?php
namespace Bot\Handlers;

use App\Models\Forum;
use App\Models\Movie;
use App\Models\Serial;
use App\Models\User;
use Bot\Keyboards\Keyboard;
use SergiX44\Nutgram\Nutgram;

class MainHandler
{
    use Keyboard;

    public function start(Nutgram $bot)
    {
        $id   = $bot->chatId();
        $name = $bot->user()->first_name . ' ' . $bot->user()->last_name;

        sendMessage($bot, "<b>👋Salom <a href='{$id}'>{$name}</a>\n\nBotimizga xush kelibsiz.\n\n🍿 Kino kodini yuboring:</b>");
    }

    public function subscribe(Nutgram $bot)
    {
        $user   = User::where('user_id', $bot->chatId())->first();
        $forums = Forum::with('invites', 'invites.user')->get();

        $invitable     = $forums->where('invitable', true);
        $non_invitable = $forums->where('invitable', false);

        $forum_list = $user->invites->pluck('forum_id');
        foreach ($invitable as $forum) {
            if (! $forum_list->contains($forum->id)) {
                return answerCallbackQuery($bot, "🤖🤚 Kechirasiz botimizdan to'liq foydalanish uchun ushbu kanallarga a'zo bo'lishingiz kerak👇", true);
            }
        }

        foreach ($non_invitable as $forum) {
            if (! isChatMember($bot, $forum->tele_id, $bot->chatId())) {
                return answerCallbackQuery($bot, "🤖🤚 Kechirasiz botimizdan to'liq foydalanish uchun ushbu kanallarga a'zo bo'lishingiz kerak👇", true);
            }
        }

        $bot->message()->delete();

        $this->start($bot);
    }

    public function join_request(Nutgram $bot)
    {
        $tele_id = $bot->chatJoinRequest()->chat->id;
        $user_id = $bot->chatJoinRequest()->from->id;

        $forum = Forum::where('tele_id', $tele_id)->first();
        $user  = User::where('user_id', $user_id)->first();

        $forum->invites()->create([
            'user_id' => $user->id,
        ]);
    }

    public function remove(Nutgram $bot)
    {
        $bot->message()->delete();
    }

    public function start_code(Nutgram $bot, $id)
    {
        $movie = Movie::find($id);

        if (! $movie) {
            return sendMessage($bot, '❌ Ushbu kodga hech qaysi film biriktirilmagan!');
        }

        if ($movie->serials()->exists()) {
            return sendVideo($bot, $movie->serials[0]->file_id, $movie->serials[0]->caption, 'html', $this->serials_page_key($movie));
        }

        $movie->increment('downloads');

        sendVideo($bot, $movie->file_id, $movie->caption . "\n\n@" . config('nutgram.username') . ' orqali yuklab olindi!', 'html', $this->submovie_key($id));
    }

    public function code(Nutgram $bot)
    {
        $id    = $bot->message()->text;
        $movie = Movie::find($id);

        if (! $movie) {
            return sendMessage($bot, '❌ Ushbu kodga hech qaysi film biriktirilmagan!');
        }

        if ($movie->serials()->exists()) {
            return sendVideo($bot, $movie->serials[0]->file_id, $movie->serials[0]->caption, 'html', $this->serials_page_key($movie));
        }

        $movie->increment('downloads');

        sendVideo($bot, $movie->file_id, $movie->caption . "\n\n@" . config('nutgram.username') . ' orqali yuklab olindi!', 'html', $this->submovie_key($id));
    }

    public function serial(Nutgram $bot, $index, $id)
    {
        $serial = Serial::find($id);

        if (! $serial) {
            return sendMessage($bot, '❌ Ushbu qism bazadan o\'chirib tashlangan yoki mavjud emas!');
        }

        $bot->message()->delete();
        $serial->increment('downloads');

        sendVideo($bot, $serial->file_id, $serial->caption, 'html', $this->serials_choose_key($serial, $index));
    }

    public function serial_page(Nutgram $bot, $id, $page)
    {
        $movie = Movie::find($id);

        if (! $movie) {
            $bot->message()->delete();

            return sendMessage($bot, '❌ Ushbu qism bazadan o\'chirib tashlangan yoki mavjud emas!');
        }

        $perPage = 10;
        $offset  = ($page - 1) * $perPage;

        $page_key = $this->serials_page_key($movie, $page);

        if (! $page_key) {
            return answerCallbackQuery($bot, '❌ Ushbu sahifa mavjud emas', true);
        }

        $bot->message()->delete();

        sendVideo($bot, $movie->serials[$offset]->file_id, $movie->serials[$offset]->caption, 'html', $page_key);
    }
}
