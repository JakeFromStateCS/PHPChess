<?php

declare(strict_types=1);

namespace PHPChess\Util\Resque;

abstract class BaseResqueJob
{
    final public function __construct(protected array $args = [])
    {
    }

    final public static function perform(array $args): void {
        $job = new static($args);
        $job->run();
    }

    abstract public function run();
}
