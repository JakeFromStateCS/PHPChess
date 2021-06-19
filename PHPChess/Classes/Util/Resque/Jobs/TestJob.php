<?php

declare(strict_types=1);

namespace PHPChess\Util\Resque\Jobs;

use PHPChess\Util\Resque\BaseResqueJob;

final class TestJob extends BaseResqueJob
{
    public function run(): void
    {
        echo $this->args['name'];
    }
}
