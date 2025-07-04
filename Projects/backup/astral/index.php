<?php

use danog\MadelineProto\Logger as MadelineProtoLogger;
use danog\MadelineProto\Settings\Logger;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/handler.php';

try {
    $logger = new Logger;
    $logger->setExtra(function () {});
    $logger->setType(MadelineProtoLogger::LOGGER_CALLABLE);
    $logger->setLevel(MadelineProtoLogger::LEVEL_ERROR);

    UserHandler::startAndLoop('session.madeline', $logger);
} catch (Throwable $e) {
    if (str_contains($e->getMessage(), 'SIGINT')) {
        print(PHP_EOL . PHP_EOL . 'Shutdown triggered' . PHP_EOL);
    }
}