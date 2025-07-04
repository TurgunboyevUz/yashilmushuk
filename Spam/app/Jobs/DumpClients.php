<?php
namespace App\Jobs;

use App\Models\Group;
use App\Models\Telegram;
use Carbon\Carbon;
use danog\MadelineProto\API;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DumpClients implements ShouldQueue
{
    private $username;

    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct($username)
    {
        $this->username = $username;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = Telegram::where('active', 1)->first();

        if (! $user) {return;}

        $group = Group::where('username', $this->username)->first();

        if ($group->is_dumped) {return;}

        $api = new API($user->session_path);
        $api->start();

        $chat         = $api->getPwrChat('@' . $this->username);
        $participants = $chat['participants'];

        foreach ($participants as $participant) {
            $first_name = $participant['user']['first_name'] ?? null;

            if (! $first_name) {continue;}

            $id        = $participant['user']['id'];
            $last_name = $participant['user']['last_name'] ?? null;
            $username  = $participant['user']['username'] ?? null;

            $was_online = $participant['user']['status']['was_online'] ?? null;

            if (! $username) {continue;}

            if (! $was_online) {continue;}

            $time = Carbon::parse($was_online);
            if ($time->isBefore(now()->subDay())) {continue;}

            $client = $group->clients()->create([
                'user_id'    => $id,
                'first_name' => $first_name,
                'last_name'  => $last_name,
                'username'   => $username,
            ]);
        }

        $group->is_dumped = true;
        $group->save();
    }
}
