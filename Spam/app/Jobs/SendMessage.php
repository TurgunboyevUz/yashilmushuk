<?php
namespace App\Jobs;

use App\Models\Client;
use App\Models\Message;
use App\Models\Telegram;
use Carbon\Carbon;
use danog\MadelineProto\API;
use danog\MadelineProto\LocalFile;
use danog\MadelineProto\RPCErrorException;
use danog\MadelineProto\RPCError\PrivacyPremiumRequiredError;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendMessage implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // get active message
        $message = Message::where('active', true)->first();

        $clients = Client::where('status', false)->get();

        foreach ($clients as $client) {
            // selecting active account
            $tg = Telegram::where('today_send_message_count', '<', 35)
                ->where('last_send_message_at', '<', Carbon::now()->addMinutes(10))
                ->where('active', 1)
                ->first();

            if (! $tg) {
                continue;
            }

            if ($tg) {
                try {
                    $api = new API($tg->session_path);
                    $api->start();

                    $file = ($message->content_type == 'text') ? null : new LocalFile(storage_path('app/public/' . $message->content_path));
                    $username = '@' . $client->username;

                    switch ($message->content_type) {
                        case 'text':
                            $api->sendMessage($username, $message->text);
                            break;
                        case 'image':
                            $api->sendPhoto($username, $file, caption: $message->text);
                            break;
                        case 'video':
                            $api->sendVideo($username, $file, caption: $message->text);
                            break;
                        case 'audio':
                            $api->sendAudio($username, $file, caption: $message->text);
                            break;
                        case 'file':
                            $api->sendDocument($username, $file, caption: $message->text);
                            break;
                    }

                    // update client
                    $client->status = true;
                    $client->save();

                    // update telegram
                    $tg->today_send_message_count++;
                    $tg->last_send_message_at = Carbon::now();
                    $tg->save();
                } catch (PrivacyPremiumRequiredError $e) {
                    $client->delete();
                    continue;
                } catch (RPCErrorException $e) {
                    if ($e->getMessage() == 'PEER_FLOOD' and mb_stripos($e->description, 'spam') !== false) {
                        $tg->active = 2;
                        $tg->save();
                    }
                } catch (Throwable $e) {
                    Log::error($e);
                }
            }
        }
    }
}
