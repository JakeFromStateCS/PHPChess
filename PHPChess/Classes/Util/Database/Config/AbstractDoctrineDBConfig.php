<?php

declare(strict_types=1);

namespace PHPChess\Util\Database\Config;

abstract class AbstractDoctrineDBConfig extends AbstractDBConfig
{
    abstract public function getModelPaths(): array;

    abstract public function getProxyDirectory(): string;

    abstract public function getProxyNamespace(): string;

    abstract public function getAutogenerateProxyConfiguration(): int;
}
