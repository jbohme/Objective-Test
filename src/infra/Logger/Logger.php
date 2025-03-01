<?php

namespace Infra\Logger;

use Throwable;

class Logger
{
    private static string $logDir = __DIR__ . '/../../storage/logs';

    public static function log(string $message, string $level = 'INFO', ?Throwable $exception = null): void
    {
        $date = date('Y-m-d H:i:s');
        $fileName = date('Y-m-d') . '.log';
        $logMessage = "[$date] [$level] - $message";

        if ($exception) {
            $logMessage .= PHP_EOL . self::formatException($exception);
        }
        $logMessage .= PHP_EOL;

        $logPath = self::$logDir . '/' . $fileName;
        error_log($logMessage, 3, $logPath);
    }

    public static function info(string $message, ?Throwable $exception = null): void
    {
        self::log($message, 'INFO', $exception);
    }

    public static function warning(string $message, ?Throwable $exception = null): void
    {
        self::log($message, 'WARNING', $exception);
    }

    public static function error(string $message, ?Throwable $exception = null): void
    {
        self::log($message, 'ERROR', $exception);
    }

    public static function debug(string $message, ?Throwable $exception = null): void
    {
        self::log($message, 'DEBUG', $exception);
    }

    private static function formatException(Throwable $exception): string
    {
        return sprintf(
            "Exception: %s in %s:%d\nStack trace:\n%s",
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );
    }
}
