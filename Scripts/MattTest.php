<?php

declare(strict_types=1);

use PHPChess\Game\Board\Board;
use PHPChess\Game\Board\StateImporters\FENStateImporter;
use PHPChess\Game\Pieces\Pawn;
use PHPChess\Util\Vector2D;

require '/var/www/html/vendor/autoload.php';

$board = new Board();
//$piece = new Pawn($board);
//$piece->setPosition(new Vector2D(3, 5));
//var_dump(PHP_EOL . $board->exportBoardState());
//$piece->move(new Vector2D(3, 6));
//var_dump(PHP_EOL . $board->exportBoardState());
//$piece->move(new Vector2D(3, 7));
//$board->exportBoardState();
(new FENStateImporter($board))->importState('rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1');
var_dump($board->exportState());