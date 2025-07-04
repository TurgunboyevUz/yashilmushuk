<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use SergiX44\Nutgram\Nutgram;
use Throwable;

class BotRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Nutgram bot run';

    /**
     * Execute the console command.
     */
    public function handle(Nutgram $bot)
    {
        try {
            $bot->run();
        } catch (Throwable $e) {
            sleep(3);

            $this->handle($bot);
            $this->error('Fatal bot error: ' . $e->getMessage());
            logger()->critical($e);

            gc_collect_cycles();
        }
    }
}
