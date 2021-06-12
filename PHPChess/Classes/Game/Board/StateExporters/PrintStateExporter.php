<?php

declare(strict_types=1);

namespace PHPChess\Game\Board\StateExporters;

class PrintStateExporter extends BoardStateExporter
{
    public function exportState(): string
    {
        $boardState = PHP_EOL . '   A  B  C  D  E  F  G  H' . PHP_EOL;
        foreach ($this->board->getBoardState() as $k => $columns) {
            $boardState .= $k . ' ';
            foreach ($columns as $column) {
                if ($column === null) {
                    $boardState .= '[ ]';
                } else {
                    $boardState .= "[{$column->getCharacter()}]";
                }
            }
            $boardState .= PHP_EOL;
        }
        return $boardState;
    }
}
