<?php

declare(strict_types=1);

namespace Framework\Classes\Util\Resque;

use Resque\Worker;

final class ResqueWorker
{
    private Worker $worker;

    public function __construct(string $queue = '*', bool $blocking = true, int $interval = 10, int $timeout = 60, int $memory = 128)
    {
        $this->worker = new Worker($queue, $blocking);
        $this->worker->setInterval($interval);
        $this->worker->setInterval($interval);
        $this->worker->setTimeout($timeout);
        $this->worker->setMemoryLimit($memory);
    }

    public function run(): void
    {
        $this->worker->work();
    }
}

