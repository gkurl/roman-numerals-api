<?php

namespace App\Logging;

use Illuminate\Log\Logger as IlluminateLogger;
use Monolog\Formatter\JsonFormatter;
use Monolog\Logger as MonologLogger;

class CustomJSONFormatter
{
    public function __invoke($logger): void
    {
        if ($logger instanceof IlluminateLogger) {
            $monolog = $logger->getLogger();
        } elseif ($logger instanceof MonologLogger) {
            $monolog = $logger;
        } else {
            return;
        }
        foreach ($monolog->getHandlers() as $handler) {
            $handler->setFormatter(new JsonFormatter(JsonFormatter::BATCH_MODE_JSON, true, true));
        }
    }
}
