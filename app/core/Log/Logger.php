<?php

namespace Core\Log;

class Logger
{
    private static $instance = null;
    private $config;
    private $logFile;

    private function __construct()
    {
        $this->config = require __DIR__ . '/../../config/config.php';
        $this->logFile = $this->config['logs']['directory'] . '/app.log';
        
        if (!is_dir($this->config['logs']['directory'])) {
            mkdir($this->config['logs']['directory'], 0755, true);
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function log($level, $message, array $context = [])
    {
        if (!$this->shouldLog($level)) {
            return;
        }

        $logEntry = $this->formatLogEntry($level, $message, $context);
        $this->writeLog($logEntry);
    }

    private function shouldLog($level)
    {
        $levels = [
            'debug' => 100,
            'info' => 200,
            'warning' => 300,
            'error' => 400,
            'critical' => 500
        ];

        $configLevel = strtolower($this->config['logs']['level']);
        return $levels[$level] >= $levels[$configLevel];
    }

    private function formatLogEntry($level, $message, array $context)
    {
        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? json_encode($context) : '';
        
        return sprintf(
            "[%s] %s: %s %s\n",
            $timestamp,
            strtoupper($level),
            $message,
            $contextStr
        );
    }

    private function writeLog($entry)
    {
        file_put_contents($this->logFile, $entry, FILE_APPEND | LOCK_EX);
    }

    public function debug($message, array $context = [])
    {
        $this->log('debug', $message, $context);
    }

    public function info($message, array $context = [])
    {
        $this->log('info', $message, $context);
    }

    public function warning($message, array $context = [])
    {
        $this->log('warning', $message, $context);
    }

    public function error($message, array $context = [])
    {
        $this->log('error', $message, $context);
    }

    public function critical($message, array $context = [])
    {
        $this->log('critical', $message, $context);
    }
} 