<?php
namespace App\Console\Commands;

use App\Traits\ConsoleLog;
use Illuminate\Console\Command;
use SergiX44\Nutgram\Nutgram;
use Throwable;

class BotRun extends Command
{
    use ConsoleLog;

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
    protected $description = 'Nutgram Bot Run';

    /**
     * Execute the console command.
     */
    public function handle(Nutgram $bot)
    {
        try {
            $bot->run();
        } catch (Throwable $e) {
            sleep(3);

            $this->log($e->getMessage());

            $this->handle($bot);
        }
    }
}
