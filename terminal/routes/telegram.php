<?php
/** @var SergiX44\Nutgram\Nutgram $bot */

use Bot\Handlers\CLIHander;
use SergiX44\Nutgram\Nutgram;

$bot->onCommand('start', [CLIHander::class, 'start']);
$bot->onCommand('cli {command}', [CLIHander::class, 'cli']);