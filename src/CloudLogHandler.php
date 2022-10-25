<?php

namespace Ermolinme\CloudLog;

use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractProcessingHandler;

class CloudLogHandler extends AbstractProcessingHandler
{
    private $config;
    private $apiToken;
    private $channelId;
    private $loggerPW;

    public function __construct(array $config)
    {   
        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level, true);

        $this->config = $config;
        $this->apiToken = $this->getConfigValue('api_token');
        $this->channelId   = $this->getConfigValue('channel_id');
        $this->loggerPW = new CloudLog($this->apiToken);
    }

    /**
     * @param array $record
     */
    public function write(array $record): void
    {
        $this
            ->loggerPW
            ->channel($this->channelId)
            ->log($record['level_name'], $record['formatted']);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new LineFormatter("%message% %context% %extra%\n", null, false, true);
    }

    /**
     * @param string $key
     * @return string
     */
    private function getConfigValue(string $key): string
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }
        
        return config(null ?: "cloud_log.$key");
    }
}
