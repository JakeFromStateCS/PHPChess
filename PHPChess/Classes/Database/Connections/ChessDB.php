<?php

declare(strict_types=1);

namespace PHPChess\Database\Connections;

use PHPChess\Database\Config\ChessDBConfig;
use PHPChess\Util\Database\AbstractDoctrineDB;
use PHPChess\Util\Database\Config\AbstractDoctrineDBConfig;

final class ChessDB extends AbstractDoctrineDB
{
    public function getConfig(): AbstractDoctrineDBConfig
    {
        return new ChessDBConfig();
    }
}
