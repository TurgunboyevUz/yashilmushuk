<?php
namespace App\Console\Commands;

use App\Handlers\UserHandler;
use danog\MadelineProto\Logger as MadelineProtoLogger;
use danog\MadelineProto\Settings\Logger;
use danog\MadelineProto\Shutdown;
use function Laravel\Prompts\info;
use Illuminate\Console\Command;
use Throwable;

class UserRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $logger = new Logger;
            $logger->setExtra(function () {});
            $logger->setType(MadelineProtoLogger::LOGGER_CALLABLE);
            $logger->setLevel(MadelineProtoLogger::LEVEL_NOTICE);

            UserHandler::startAndLoop(storage_path('sessions/user.madeline'), $logger);
        } catch (Throwable $e) {
            if(str_contains($e->getMessage(), 'SIGINT')) {
                info('Shutdown triggered');
            }
        }
    }
}
