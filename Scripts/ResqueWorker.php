<?php

declare(strict_types=1);

require '/var/www/html/vendor/autoload.php';

$redisDSN = '127.0.0.1:6379';
putenv('REDIS_BACKEND=' . $redisDSN);

$resque = '/var/www/html/vendor/mjphaynes/php-resque/bin/resque';
require_once $resque;