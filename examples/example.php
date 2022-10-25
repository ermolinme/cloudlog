<?php

use Ermolinme\CloudLog\CloudLog;

require __DIR__ . '/../vendor/autoload.php';

$loggerPW = new CloudLog('API_TOKEN');
$loggerPW->channel('CHANNEL_ID')->info('Hello world!');