<?php

declare(strict_types=1);

namespace PHPChess\Database\Models;

use PHPChess\Util\Database\AbstractDoctrineDB;

abstract class AbstractModel
{
    public static function getBy(array $filters = []): array
    {

    }

    public function save(bool $flushAll = false): void
    {
        $em = $this->getDatabase()->getEntityManager();
        $em->persist($this);
        if ($flushAll === true) {
            $em->flush();
        } else {
            $em->flush($this);
        }
    }

    abstract public function getDatabase(): AbstractDoctrineDB;
}
