<?php

declare(strict_types=1);

namespace PHPChess\Game\Pieces;

use PHPChess\Enum\Constants;
use PHPChess\Game\Board\Board;
use PHPChess\Util\Vector2D;

class Pawn extends ChessPiece
{
    private Vector2D $forwardDirection;

    public function __construct(Board $board, int $team = 0)
    {
        parent::__construct($board, $team);
        // Set our forward direction. Moves 1 if light, -1 if dark.
        $this->forwardDirection = new Vector2D(0, $team === Constants::TEAM_LIGHT ? 1 : -1);
    }

    public function getCharacter(): string
    {
        return 'P';
    }

    public function getValidMoves(): array
    {
        // Return default moves
        $currentPosition = $this->getPosition();
        $validMoves = [
            $currentPosition->add($this->forwardDirection)
        ];
        if ($this->getMoveCount() === 0) {
            $validMoves[] = $this->forwardDirection->mul(2);
        }
        // TODO: Check for enemies here
        return $validMoves;
    }
}
