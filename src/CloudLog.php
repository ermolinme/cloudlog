<?php

namespace Ermolinme\CloudLog;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CloudLog
{
    const URL = 'https://api.cloudlog.me/v1/';

    protected $client;
    protected $channel;
    protected $tags = [];

    public function __construct(string $token)
    {
        $this->client = new Client([
            'base_uri' => self::URL,
            'headers' => [
                'Authorization' => $token
            ]
        ]);
    }

    /**
     * @param $channel
     * @return CloudLog
     */
    public function channel($channel): CloudLog
    {
        $this->channel = $channel;
        return $this;
    }

    /**
     * @param array $tags
     * @return $this
     */
    public function tags(array $tags): CloudLog
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @param string $tag
     * @return $this
     */
    public function tag(string $tag): CloudLog
    {
        $this->tags[] = $tag;
        return $this;
    }

    /**
     * @param string $level
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function log(string $level, string $message, array $context = []): bool
    {
        if (! $this->channel) {
            return false;
        }

        $data = [
            'channel' => $this->channel,
            'level' => $level,
            'message' => $message,
            'context' => $context,
            'tags' => array_unique($this->tags)
        ];

        try {
            $resp = $this->client->request('POST', 'logs', [
                'json' => $data
            ]);
            $respData = json_decode($resp->getBody()->getContents(), true);

            return $respData['success'];
        } catch (GuzzleException|Exception $e) {
            return false;
        }
    }

    /**
     * @param string $message
     * @param array $context
     *
     * @return bool
     */
    public function debug(string $message, array $context = []): bool
    {
        return $this->log(LogLevel::DEBUG, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function info(string $message, array $context = []): bool
    {
        return $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function notice(string $message, array $context = []): bool
    {
        return $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function warning(string $message, array $context = []): bool
    {
        return $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function error(string $message, array $context = []): bool
    {
        return $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function critical(string $message, array $context = []): bool
    {
        return $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function alert(string $message, array $context = []): bool
    {
        return $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * @param string $message
     * @param array $context
     * @return bool
     */
    public function emergency(string $message, array $context = []): bool
    {
        return $this->log(LogLevel::EMERGENCY, $message, $context);
    }
}