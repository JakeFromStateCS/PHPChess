<?php

declare(strict_types=1);

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use PHPChess\Database\Connections\ChessDB;
use Symfony\Component\Console\Helper\HelperSet;

require '/var/www/html/vendor/autoload.php';

$em = (new ChessDB())->getEntityManager();
return new HelperSet([
    'em' => new EntityManagerHelper($em),
    'db' => new ConnectionHelper($em->getConnection()),
]);
