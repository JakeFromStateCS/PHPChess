<?php

declare(strict_types=1);

namespace PHPChess\Util\Resque;

use Resque\Logger;

final class ResqueLogger extends Logger
{
    public function log($message, $context = null, $logType = null)
    {
        file_put_contents('/var/www/html/log.log', $message . PHP_EOL, FILE_APPEND);
    }
}
