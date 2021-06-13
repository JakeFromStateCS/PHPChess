<?php

declare(strict_types=1);

namespace PHPChess\Framework\Game\Board;

use PHPChess\Game\Board\Board;

final class TestBoard
{
    public static function create(): Board
    {
        $board = new Board();
        // Set it up with the default pieces
        $board->importState('rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1');
        return $board;
    }
}
