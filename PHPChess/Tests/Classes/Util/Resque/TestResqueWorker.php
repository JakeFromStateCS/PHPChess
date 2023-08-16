<?php

declare(strict_types=1);

namespace PHPChess\Tests\Util\Resque;

use PHPChess\Database\Models\LogModel;
use PHPChess\Tests\Framework\Util\Resque\Jobs\TestJob;
use PHPUnit\Framework\TestCase;
use Resque;

final class TestResqueWorker extends TestCase
{
    private ?LogModel $logModel;

    public function testResqueWorker(): void
    {
        // Run the ResqueWorker
        (new TestResqueWorker())->run();
        // Try to get the log that would've been created from the TestJob
        $newLogModel = LogModel::findOneBy(['message' => 'TestResqueWorker']);
        // One must exist
        $this->assertNotNull($newLogModel);
        // The id of the new log cannot be the id of the old log
        $this->assertNotSame($this->logModel?->getId(), $newLogModel->getId());
    }

    public function setUp(): void
    {
        parent::setUp();
        // Add a new job to the resque-queue?
        Resque::push(TestJob::class, ['message' => 'TestResqueWorker', 'className' => self::class]);
        // Set the log model to the most recent just in case it wasn't cleaned up somehow
        $this->logModel = LogModel::findOneBy([], ['id' => 'DESC']);
    }
}
