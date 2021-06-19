<?php

declare(strict_types=1);

namespace PHPChess\Game\Board\StateImporters;

use PHPChess\Enum\Constants;
use PHPChess\Game\Pieces\Bishop;
use PHPChess\Game\Pieces\ChessPiece;
use PHPChess\Game\Pieces\King;
use PHPChess\Game\Pieces\Knight;
use PHPChess\Game\Pieces\Pawn;
use PHPChess\Game\Pieces\Queen;
use PHPChess\Game\Pieces\Rook;
use PHPChess\Util\Spacial\Vector2D;

final class FENStateImporter extends BoardStateImporter
{
    private array $pieceCharacterMap = [
        'K' => King::class,
        'N' => Knight::class,
        'B' => Bishop::class,
        'R' => Rook::class,
        'P' => Pawn::class,
        'Q' => Queen::class,
    ];

    public function importState(mixed $export): void
    {
        // Split on spaces to get each section
        [
            $piecePlacement,
            $activeColor,
            $castlingAvailability,
            $enPassantTarget,
            $halfMoveClock,
            $fullMoveNumber
        ] = explode(' ', $export);
        // Split on forward slashes to get each column
        $pieceRows = explode('/', $piecePlacement);
        foreach ($pieceRows as $rowIndex => $pieceRow) {
            $this->updateRow($rowIndex + 1, $pieceRow);
        }
    }

    private function updateRow(int $rowIndex, string $rowNotation): void
    {
        if (!is_numeric($rowNotation)) {
            $pieceCharacters = str_split($rowNotation);
            foreach ($pieceCharacters as $columnIndex => $pieceCharacter) {
                $positionX = $columnIndex + 1;
                $position = new Vector2D($positionX, $rowIndex);
                $pieceCharacterUpper = strtoupper($pieceCharacter);
                /** @var ChessPiece $piece */
                $piece = new $this->pieceCharacterMap[$pieceCharacterUpper]($this->board);
                $piece->setPosition($position);
                // If it's lowercase it's dark
                $piece->setTeam(ctype_lower($pieceCharacter) ? Constants::TEAM_DARK : Constants::TEAM_LIGHT);
            }
        }
    }
}
