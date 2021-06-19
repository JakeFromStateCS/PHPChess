<?php

declare(strict_types=1);

namespace PHPChess\Game\Pieces;

use PHPChess\Game\Board\Board;
use PHPChess\Util\Spacial\Vector2D;

abstract class ChessPiece
{
    private Vector2D $position;
    // Track the total number of moves. Specifically useful for kings and pawns
    private int $moveCount = 0;

    public function __construct(protected Board $board, private int $team = 0)
    {
        $this->position = new Vector2D(1, 1);
    }

    final public function setPosition(Vector2D $position)
    {
        $this->board->setChessPiecePosition($this, $position);
        $this->position = $position;
    }

    final public function getPosition(): Vector2D
    {
        return $this->position;
    }

    final public function move(Vector2D $position): void
    {
        $this->assertValidMove($position);
        $this->board->moveChessPiece($this, $position);
        $this->position = $position;
        $this->moveCount++;
    }

    final public function isValidMove(Vector2D $position): bool
    {
        $validMoves = $this->getValidMoves();
        foreach ($validMoves as $validMove) {
            if ($validMove->getY() === $position->getY() && $validMove->getX() === $position->getX()) {
                return true;
            }
        }
        return false;
    }

    final public function assertValidMove(Vector2D $position): void
    {
        if ($this->isValidMove($position) === false) {
            throw new \Exception('Invalid Move.');
        }
    }

    final public function getTeam(): int
    {
        return $this->team;
    }

    final public function setTeam(int $team): void
    {
        $this->team = $team;
    }

    final public function getMoveCount(): int
    {
        return $this->moveCount;
    }

    // TODO: Write code to determine invalid moves
    //  Based on things such as:
    //  - Whether pieces are blocking movement
    //  - Whether the moves go beyond the board
    public function getInvalidMoves(array $potentialMoves = []): array
    {
        return [];
    }

    /**
     * @return Vector2D[]
     */
    abstract public function getValidMoves(): array;

    abstract public function getCharacter(): string;
}
