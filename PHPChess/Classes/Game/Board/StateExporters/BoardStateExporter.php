<?php

declare(strict_types=1);

namespace PHPChess\Game\Board\StateExporters;

use PHPChess\Game\Board\Board;

/**
 * This is intended as a decorator for the board to be used for exporting the board state
 * It is/will be used by classes for exporting the board state in various formats such as FEN/PGN
 * Class BoardStateExporter
 * @package PHPChess\Game\Board\StateExporters
 */
abstract class BoardStateExporter
{
    public function __construct(protected Board $board)
    {
    }

    /**
     * This will export the state of the board however defined by the child classes
     * @return mixed
     */
    abstract public function exportState(): mixed;
}
