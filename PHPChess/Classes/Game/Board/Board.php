<?php

namespace PHPChess\Game\Board;

use PHPChess\Enum\Constants;
use PHPChess\Game\Board\StateExporters\BoardStateExporter;
use PHPChess\Game\Board\StateExporters\PrintStateExporter;
use PHPChess\Game\Pieces\ChessPiece;
use PHPChess\Util\Dimension2D;
use PHPChess\Util\Vector2D;

final class Board
{
    private int $moveCount;
    private int $teamToMove;
    private array $boardState;
    private BoardStateExporter $stateExporter;

    public function __construct(private ?Dimension2D $dimension = null, private int $numberOfTeams = 2)
    {
        if ($this->dimension === null) {
            // Default board size
            $this->dimension = new Dimension2D(Constants::DEFAULT_BOARD_WIDTH, Constants::DEFAULT_BOARD_HEIGHT);
        }
        $this->boardState = [];
        // Default state exporter
        $this->stateExporter = new PrintStateExporter($this);
        // Set board state to empty
        $this->resetBoardState();
    }

    public function setChessPiecePosition(ChessPiece $chessPiece, Vector2D $vector2D): void
    {
        $currentChessPiecePosition = $chessPiece->getPosition();
        $this->assertValidPosition($vector2D);
        $currentPiece = $this->boardState[$currentChessPiecePosition->getY()][$currentChessPiecePosition->getX()];
        if ($currentPiece !== null && $currentPiece === $chessPiece) {
            $this->boardState[$currentChessPiecePosition->getY()][$currentChessPiecePosition->getX()] = null;
        }
        $this->boardState[$vector2D->getY()][$vector2D->getX()] = $chessPiece;
    }

    public function getChessPiece(Vector2D $vector2D): ?ChessPiece
    {
        $this->assertValidPosition($vector2D);
        return $this->boardState[$vector2D->getY()][$vector2D->getX()];
    }

    public function moveChessPiece(ChessPiece $ChessPiece, Vector2D $vector2D): void
    {
        if ($ChessPiece->getTeam() !== $this->teamToMove) {
            throw new \Exception('Not your turn.');
        }
        $this->setChessPiecePosition($ChessPiece, $vector2D);
        // Increment the move count
        $this->moveCount++;
        $this->teamToMove++;
        // Let the next team move, if we're on the last one, reset it
        if ($this->teamToMove > $this->numberOfTeams - 1) {
            $this->resetTeamToMove();
        }
    }

    public function setTeamToMove(int $teamToMove): void
    {
        if ($teamToMove > $this->numberOfTeams) {
            throw new \Exception('Invalid Team.');
        }
        $this->teamToMove = $teamToMove;
    }

    public function exportBoardState()
    {
        return $this->stateExporter->exportState();
    }

    public function getBoardState(): array
    {
        return $this->boardState;
    }

    private function isValidPosition(Vector2D $vector2D): bool
    {
        return $vector2D->getY() <= $this->dimension->getHeight() && $vector2D->getX() <= $this->dimension->getWidth();
    }

    private function assertValidPosition(Vector2D $vector2D): void
    {
        if ($this->isValidPosition($vector2D) === false) {
            throw new \Exception('Invalid Position.');
        }
    }

    private function resetBoardState(): void
    {
        for ($row = 1; $row <= $this->dimension->getHeight(); $row++) {
            $this->boardState[$row] = [];
            for ($col = 1; $col <= $this->dimension->getWidth(); $col++) {
                $this->boardState[$row][$col] = null;
            }
        }

        // Set the move count and team turn
        $this->moveCount = 0;
        $this->resetTeamToMove();
    }

    private function resetTeamToMove(): void
    {
        $this->setTeamToMove(Constants::DEFAULT_TEAM_TURN);
    }
}