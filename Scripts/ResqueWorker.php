<?php

declare(strict_types=1);

use PHPChess\Util\Resque\ResqueWorker;

require '/var/www/html/vendor/autoload.php';

$worker = new ResqueWorker(blocking: false);
$worker->run();