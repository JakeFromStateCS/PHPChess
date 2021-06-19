<?php

declare(strict_types=1);

namespace PHPChess\Database\Models;

use PHPChess\Database\Connections\ChessDB;
use PHPChess\Util\Database\AbstractDoctrineDB;

abstract class AbstractChessDBModel extends AbstractModel
{
    public function getDatabase(): AbstractDoctrineDB
    {
        return new ChessDB();
    }
}
