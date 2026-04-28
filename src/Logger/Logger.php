<?php

namespace App\Logger;

class Logger
{
    public function __construct(private string $logPath)
    {
        if (!is_dir(dirname($this->logPath))) {
            mkdir(dirname($this->logPath), 0755, true);
        }
    }

    public function info(string $message): void
    {
        $this->write('INFO', $message);
    }

    public function error(string $message): void
    {
        $this->write('ERROR', $message);
    }

    public function warning(string $message): void
    {
        $this->write('WARNING', $message);
    }

    private function write(string $level, string $message): void
    {
        $line = '[' . date('Y-m-d H:i:s') . '] [' . $level . '] ' . $message . PHP_EOL;
        file_put_contents($this->logPath, $line, FILE_APPEND);
    }
}
