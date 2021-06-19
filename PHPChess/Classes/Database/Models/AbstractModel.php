<?php

declare(strict_types=1);

namespace PHPChess\Database\Models;

use PHPChess\Util\Database\AbstractDoctrineDB;

abstract class AbstractModel
{

    public static function get($id): static
    {
        $instance = static::getDatabase()->getEntityManager()->getRepository(static::class)->find($id);
        if ($instance === null) {
            throw new \Exception('Not Found.');
        }
        return $instance;
    }

    public static function getBy(array $filters = [], array $orderBy = []): array
    {
        return static::getDatabase()->getEntityManager()->getRepository(static::class)->findBy($filters, $orderBy);
    }

    public static function findOneBy(array $filters, array $orderBy = []): static|null
    {
        return static::getDatabase()->getEntityManager()->getRepository(static::class)->findOneBy($filters, $orderBy);
    }
    
    public static function getOneBy(array $filters = [], array $orderBy = []): static
    {
        $instance = static::findOneBy($filters, $orderBy);
        if ($instance === null) {
            throw new \Exception('Not Found.');
        }
        return $instance;
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

    abstract public static function getDatabase(): AbstractDoctrineDB;
}
