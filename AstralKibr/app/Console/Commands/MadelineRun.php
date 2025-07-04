<?php

namespace App\Console\Commands;

use App\Handlers\EventHandler;
use Illuminate\Console\Command;

use function Laravel\Prompts\info;

class MadelineRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'madeline:run {path?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Madeline Event Handler';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $path = $this->argument('path') ?? 'user.madeline';

        EventHandler::startAndLoop(storage_path('sessions/' . $path));
    }
}
