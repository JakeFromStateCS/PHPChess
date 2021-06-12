<?php

declare(strict_types=1);

namespace PHPChess\Game\Pieces;

use PHPChess\Game\Board\Board;

class Rook extends ChessPiece {
    public function __construct(Board $board, int $team = 0)
    {
        parent::__construct($board, $team);
    }

    public function getCharacter(): string
    {
        return 'R';
    }

    public function getValidMoves(): array
    {
        return [];
    }
}
