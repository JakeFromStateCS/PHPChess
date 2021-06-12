<?php

declare(strict_types=1);

namespace PHPChess\Game\Board\StateImporters;

use PHPChess\Game\Board\Board;

abstract class BoardStateImporter
{
    public function __construct(protected Board $board)
    {
    }

    abstract public function importState(mixed $export): void;
}
