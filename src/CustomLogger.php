<?php

namespace Ermolinme\CloudLog;

use Monolog\Logger;

class CustomLogger
{
    public function __invoke(array $config): Logger
    {
        return new Logger(
            config('app.name'),
            [new CloudLogHandler($config)]
        );
    }
}
