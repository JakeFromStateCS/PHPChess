<?php

declare(strict_types=1);

namespace PHPChess\Tests\Framework\Util\Resque;

use Resque\Event;
use Resque\Job;
use Resque\Logger;
use Resque\Worker;

final class TestResqueWorker extends Worker
{
    private int $messageLimit = 1;

    public function setMessageLimit(int $messageLimit): void
    {
        $this->messageLimit = $messageLimit;
    }

    public function work()
    {
        $this->log('Starting worker <pop>'.$this.'</pop>', Logger::INFO);
        $this->updateProcLine('Worker: starting...');

        $this->startup();

        $this->log('Listening to queues: <pop>'.implode(', ', $this->queues).'</pop>, with '.
            ($this->blocking ? 'timeout blocking' : 'time interval').' <pop>'.$this->interval_string().'</pop>', Logger::INFO);
        $processedMessageCount = 0;
        while (true && $processedMessageCount < $this->messageLimit) {
            $processedMessageCount++;
            if ($this->memoryExceeded()) {
                $this->log('Worker memory has been exceeded, aborting', Logger::CRITICAL);
                $this->shutdown();

                Event::fire(Event::WORKER_LOW_MEMORY, $this);
            }

            if (!$this->redis->sismember(self::redisKey(), $this->id) or $this->redis->hlen(self::redisKey($this)) == 0) {
                $this->log('Worker is not in list of workers or packet is corrupt, aborting', Logger::CRITICAL);
                $this->shutdown();

                Event::fire(Event::WORKER_CORRUPT, $this);
            }

            $this->shutdown = $this->redis->hget(self::redisKey($this), 'shutdown');

            if ($this->shutdown) {
                $this->log('Shutting down worker <pop>'.$this.'</pop>', Logger::INFO);
                $this->updateProcLine('Worker: shutting down...');
                break;
            }

            if ($this->status == self::STATUS_PAUSED) {
                $this->log('Worker paused, trying again in '.$this->interval_string(), Logger::INFO);
                $this->updateProcLine('Worker: paused');
                sleep($this->interval);
                continue;
            }

            $this->host->working($this);
            $this->redis->hmset(self::redisKey($this), 'memory', memory_get_usage());

            Event::fire(Event::WORKER_WORK, $this);

            if (!count($this->resolveQueues())) {
                $this->log('No queues found, waiting for '.$this->interval_string(), Logger::INFO);
                sleep($this->interval);
                continue;
            }

            $this->queueDelayed();

            if ($this->blocking) {
                $this->log('Pop blocking with timeout of '.$this->interval_string(), Logger::DEBUG);
                $this->updateProcLine('Worker: waiting for job on '.implode(',', $this->queues).' with blocking timeout '.$this->interval_string());
            } else {
                $this->updateProcLine('Worker: waiting for job on '.implode(',', $this->queues).' with interval '.$this->interval_string());
            }

            $job = \Resque::pop($this->resolveQueues(), $this->interval, $this->blocking);

            if (!$job instanceof Job) {
                if (!$this->blocking) {
                    $this->log('Sleeping for '.$this->interval_string(), Logger::DEBUG);
                    sleep($this->interval);
                }

                continue;
            }

            $this->log('Found a job <pop>'.$job.'</pop>', Logger::NOTICE);

            $this->workingOn($job);

            Event::fire(Event::WORKER_FORK, array($this, $job));

            // Fork into another process
            $this->child = pcntl_fork();

            // Returning -1 means error in forking
            if ($this->child == -1) {
                Event::fire(Event::WORKER_FORK_ERROR, array($this, $job));

                $this->log('Unable to fork process, this is a fatal error, aborting worker', Logger::ALERT);
                $this->log('Re-queuing job <pop>'.$job.'</pop>', Logger::INFO);

                // Because it wasn't the job that failed the job is readded to the queue
                // so that in can be tried again at a later time
                $job->queue();

                $this->shutdown();

                // In parent if $pid > 0 since pcntl_fork returns process id of child
            } elseif ($this->child > 0) {
                Event::fire(Event::WORKER_FORK_PARENT, array($this, $job, $this->child));

                $this->log('Forked process to run job on pid:'.$this->child, Logger::DEBUG);
                $this->updateProcLine('Worker: forked '.$this->child.' at '.strftime('%F %T'));

                // Set the PID in redis
                $this->redis->hset(self::redisKey($this), 'job_pid', $this->child);

                // Wait until the child process finishes before continuing
                pcntl_wait($status);

                if (!pcntl_wifexited($status) or ($exitStatus = pcntl_wexitstatus($status)) !== 0) {
                    if ($this->job->getStatus() == Job::STATUS_FAILED) {
                        $this->log('Job '.$job.' failed: "'.$job->failError().'" in '.$this->job->execTimeStr(), Logger::ERROR);
                    } else {
                        $this->log('Job '.$job.' exited with code '.$exitStatus, Logger::ERROR);
                        $this->job->fail(new Exception\Dirty($exitStatus));
                    }
                }
            } else {
                // Reset the redis connection to prevent forking issues
                $this->redis->disconnect();
                $this->redis->connect();

                Event::fire(Event::WORKER_FORK_CHILD, array($this, $job, getmypid()));

                $this->log('Running job <pop>'.$job.'</pop>', Logger::INFO);
                $this->updateProcLine('Job: processing '.$job->getQueue().'#'.$job->getId().' since '.strftime('%F %T'));

                $this->perform($job);
                exit(0);
            }

            $this->child = null;
            $this->doneWorking();
        }
    }
}
