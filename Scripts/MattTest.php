<?php

declare(strict_types=1);

use PHPChess\Database\Connections\ChessDB;
use PHPChess\Database\Models\LogModel;
use PHPChess\Game\Board\Board;
use PHPChess\Game\Board\StateImporters\FENStateImporter;
use PHPChess\Game\Pieces\Pawn;
use PHPChess\Util\Spacial\Vector2D;

require '/var/www/html/vendor/autoload.php';

//$log = new \PHPChess\Database\Models\LogModel(
//    'Test',
//    [
//        'Wtf'
//    ]
//);
//$log->save();
$log = LogModel::get(1);
dump($log);

//$chessDB = new ChessDB();
//$stmt = $chessDB->getPDO()->query('SHOW TABLES;');
//dump($stmt->fetchAll());


//$job = Resque::push(\PHPChess\Util\Resque\Jobs\TestJob::class, ['name' => 'test123']);
//
//
//Resque::setBackend('localhost:6379');
//$args = [
//    'name' => 'Test123',
//];
//Resque::enqueue('default', DemoJob::class, $args);