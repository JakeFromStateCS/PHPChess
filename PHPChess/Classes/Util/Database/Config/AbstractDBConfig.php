<?php

declare(strict_types=1);

namespace PHPChess\Util\Database\Config;

use PDO;

abstract class AbstractDBConfig
{
    protected array $dbConfig;

    public function __construct()
    {
        $this->dbConfig = [
            'dbname' => $this->getName(),
            'user' => $this->getUser(),
            'password' => $this->getPass(),
            'host' => $this->getHost(),
            'port' => $this->getPort(),
            'driver' => $this->getDriver(),
            'charset' => $this->getCharset(),
            'driverOptions' => $this->getDriverOptions(),
        ];
    }

    public function getPort(): int
    {
        return 3306;
    }

    public function getDriverOptions(): array
    {
        return [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false,
        ];
    }

    public function getConfigArray(): array
    {
        return $this->dbConfig;
    }

    abstract public function getName(): string;

    abstract public function getUser(): string;

    abstract public function getPass(): string;

    abstract public function getHost(): string;

    abstract public function getDriver(): string;

    abstract public function getCharset(): string;
}
