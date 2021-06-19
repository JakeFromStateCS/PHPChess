<?php

declare(strict_types=1);

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use PHPChess\Database\Connections\ChessDB;
use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require '/var/www/html/vendor/autoload.php';

$commands = [];

$em = (new ChessDB())->getEntityManager();

$helperSet = new HelperSet([
    'em' => new EntityManagerHelper($em),
    'db' => new ConnectionHelper($em->getConnection()),
]);;

if (!($helperSet instanceof HelperSet)) {
    foreach ($GLOBALS as $helperSetCandidate) {
        if ($helperSetCandidate instanceof HelperSet) {
            $helperSet = $helperSetCandidate;
            break;
        }
    }
}

ConsoleRunner::run($helperSet, $commands);