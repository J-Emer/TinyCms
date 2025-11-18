<?php

namespace Jemer\TinyCms\Helpers;

class Logger
{
    /** @var string Path to the log file */
    private static string $logFile = LOGS . DIRECTORY_SEPARATOR . "log.log";

    /**
     * Set a custom log file path
     */
    public static function setLogFile(string $path): void
    {
        self::$logFile = $path;
    }

    /**
     * Log a message
     */
    public static function info(string $message): void
    {
        self::write('INFO', $message);
    }

    public static function warning(string $message): void
    {
        self::write('WARNING', $message);
    }

    public static function error(string $message): void
    {
        self::write('ERROR', $message);
    }

    /**
     * Write the message to the log file
     */
    private static function write(string $level, string $message): void
    {
        $time = date('Y-m-d H:i:s');
        $line = "[$time] [$level] $message" . PHP_EOL;

        // Ensure the directory exists
        $dir = dirname(self::$logFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        file_put_contents(self::$logFile, $line, FILE_APPEND);
    }
}
