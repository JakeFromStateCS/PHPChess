<?php

declare(strict_types=1);

namespace PHPChess\Game\Pieces;

use PHPChess\Game\Board\Board;

class Knight extends ChessPiece {
    public function __construct(Board $board, int $team = 0)
    {
        parent::__construct($board, $team);
    }

    public function getCharacter(): string
    {
        return 'N';
    }

    public function getValidMoves(): array
    {
        return [];
    }
}
