<?php

declare(strict_types=1);

namespace PHPChess\Game\Pieces;

use PHPChess\Util\Spacial\Vector2D;

class Rook extends ChessPiece
{
    public function getCharacter(): string
    {
        return 'R';
    }

    public function getValidMoves(): array
    {
        $validMoves = [];
        // For all positions in the same Y, they are all valid moves except the current Y.
        // If they are the current Y, all X moves are possible
        $currentPosition = $this->getPosition();
        for ($y = 1; $y <= $this->board->getDimensions()->getHeight(); $y++) {
            if ($y !== $currentPosition->getY()) {
                $validMoves[] = new Vector2D($currentPosition->getX(), $y);
            } else {
                for ($x = 1; $x <= $this->board->getDimensions()->getWidth(); $x++) {
                    $validMoves[] = new Vector2D($y, $x);
                }
            }
        }
        return $validMoves;
    }
}
