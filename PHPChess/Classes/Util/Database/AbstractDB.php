<?php

declare(strict_types=1);

namespace PHPChess\Util\Database;

use PHPChess\Util\Database\Config\AbstractDBConfig;

abstract class AbstractDB
{
    abstract public function getConfig(): AbstractDBConfig;
}
