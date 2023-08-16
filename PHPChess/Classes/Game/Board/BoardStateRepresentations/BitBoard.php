<?php

declare(strict_types=1);

namespace PHPChess\Game\Board\BoardStateRepresentations;

use PHPChess\Util\Spacial\Dimension2D;

final class BitBoard
{
    public function __construct(private Dimension2D $size)
    {
    }
}
