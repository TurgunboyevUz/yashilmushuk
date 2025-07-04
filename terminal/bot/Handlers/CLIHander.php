<?php
namespace Bot\Handlers;

use SergiX44\Nutgram\Nutgram;

class CLIHander
{
    public function arrayToString($array) {
        return implode("\n", $array);
    }

    public function start(Nutgram $bot)
    {
        $exec = exec('pwd', $output, $status);

        if($status !== 0) {
            sendMessage($bot, 'Error: ' . $status);
            return;
        }

        sendMessage($bot, $this->arrayToString($output));
    }

    public function cli(Nutgram $bot, $command)
    {
        $exec = exec($command, $output, $status);

        if($status !== 0) {
            sendMessage($bot, 'Error: ' . $status);
            return;
        }

        sendMessage($bot, $this->arrayToString($output));
    }
}
