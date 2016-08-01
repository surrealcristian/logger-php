<?php

namespace SurrealCristian;

use DateTime;
use InvalidArgumentException;
use UnexpectedValueException;

class Logger
{
    const DEBUG     = 100;
    const INFO      = 200;
    const NOTICE    = 250;
    const WARNING   = 300;
    const ERROR     = 400;
    const CRITICAL  = 500;
    const ALERT     = 550;
    const EMERGENCY = 600;

    protected $name;
    protected $stream;
    protected $level;
    protected $levelNumber;
    protected $errorMessage;

    protected $levels = [
        'debug'     => self::DEBUG,
        'info'      => self::INFO,
        'notice'    => self::NOTICE,
        'warning'   => self::WARNING,
        'error'     => self::ERROR,
        'critical'  => self::CRITICAL,
        'alert'     => self::ALERT,
        'emergency' => self::EMERGENCY,
    ];

    /**
     * @param string $name Name
     * @param string $file File
     * @param string $level Level
     */
    public function __construct($name, $file, $level)
    {
        $this->errorMessage = null;

        set_error_handler([$this, 'errorHandler']);
        $stream = fopen($file, 'a');
        restore_error_handler();

        if (!is_resource($stream)) {
            throw new UnexpectedValueException(
                sprintf(
                    'The file "%s" could not be opened: %s',
                    $file,
                    $this->errorMessage
                )
            );
        }

        if (!array_key_exists($level, $this->levels)) {
            throw new InvalidArgumentException(
                sprintf('The level "%s" is invalid.', $level)
            );
        }

        $this->name = $name;
        $this->stream = $stream;
        $this->level = $level;
        $this->levelNumber = $this->levels[$level];
    }

    public function __destruct()
    {
        fclose($this->stream);
    }

    /**
     * @param string $message Message
     * @param array $context Context
     */
    public function debug($message, array $context = [])
    {
        $this->log('debug', $message, $context);
    }

    /**
     * @param string $message Message
     * @param array $context Context
     */
    public function info($message, array $context = [])
    {
        $this->log('info', $message, $context);
    }

    /**
     * @param string $message Message
     * @param array $context Context
     */
    public function notice($message, array $context = [])
    {
        $this->log('notice', $message, $context);
    }

    /**
     * @param string $message Message
     * @param array $context Context
     */
    public function warning($message, array $context = [])
    {
        $this->log('warning', $message, $context);
    }

    /**
     * @param string $message Message
     * @param array $context Context
     */
    public function error($message, array $context = [])
    {
        $this->log('error', $message, $context);
    }

    /**
     * @param string $message Message
     * @param array $context Context
     */
    public function critical($message, array $context = [])
    {
        $this->log('critical', $message, $context);
    }

    /**
     * @param string $message Message
     * @param array $context Context
     */
    public function alert($message, array $context = [])
    {
        $this->log('alert', $message, $context);
    }

    /**
     * @param string $message Message
     * @param array $context Context
     */
    public function emergency($message, array $context = [])
    {
        $this->log('emergency', $message, $context);
    }

    protected function log($level, $message, $context)
    {
        if ($this->levels[$level] >= $this->levelNumber) {
            $fields = [
                'name' => $this->name,
                'level' => $level,
                'message' => $message,
                'context' => $context,
                'datetime' => (new DateTime)->format('Y-m-d H:i:s'),
            ];
            $this->write($fields);
        }
    }

    protected function write($fields)
    {
        $message = sprintf(
            "%s %s %s: %s %s",
            strtoupper($fields['level']),
            $fields['datetime'],
            $fields['name'],
            $fields['message'],
            json_encode($fields['context'])
        );

        fwrite($this->stream, $message . PHP_EOL);
    }

    protected function errorHandler($errno, $errstr)
    {
        $this->errorMessage = $errstr;
    }
}
