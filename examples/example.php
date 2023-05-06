<?php

use Ermolinme\CloudLog\CloudLog;

require __DIR__ . '/../vendor/autoload.php';

$cloudLog = new CloudLog('API_TOKEN');
$cloudLog
    ->channel('CHANNEL_ID')
    ->info('Hello world!', ['foo' => 'bar']);