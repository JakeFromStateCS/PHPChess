<?php

declare(strict_types=1);

use Decimal\Decimal;
use PHPChess\Database\Connections\ChessDB;
use PHPChess\Database\Models\LogModel;
use PHPChess\Game\Board\Board;
use PHPChess\Game\Board\StateImporters\FENStateImporter;
use PHPChess\Game\Pieces\Pawn;
use PHPChess\Util\Spacial\Vector2D;

require '/var/www/html/vendor/autoload.php';


