<?php

declare(strict_types=1);

namespace PHPChess\Tests\Framework\Util\Resque\Jobs;

use PHPChess\Database\Models\LogModel;
use PHPChess\Util\Resque\BaseResqueJob;

final class TestJob extends BaseResqueJob
{
    public function run(): void
    {
        $log = new LogModel($this->args['message'], ['className' => $this->args['className']]);
        $log->save();
    }
}
