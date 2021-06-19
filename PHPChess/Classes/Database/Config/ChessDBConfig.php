<?php

declare(strict_types=1);

namespace PHPChess\Database\Config;

use Doctrine\Common\Proxy\AbstractProxyFactory;
use PHPChess\Util\Database\Config\AbstractDoctrineDBConfig;

final class ChessDBConfig extends AbstractDoctrineDBConfig
{
    public function getName(): string
    {
        return $_ENV['DATABASE_NAME'];
    }

    public function getUser(): string
    {
        return $_ENV['DATABASE_USER'];
    }

    public function getPass(): string
    {
        return $_ENV['DATABASE_PASS'];
    }

    public function getHost(): string
    {
        return $_ENV['DATABASE_HOST'];
    }

    public function getDriver(): string
    {
        return 'pdo_mysql';
    }

    public function getCharset(): string
    {
        return 'utf8mb4';
    }

    public function getModelPaths(): array
    {
        return [__DIR__ . '/../Models'];
    }

    public function getProxyDirectory(): string
    {
        return __DIR__ . '/../Models/Proxies';
    }

    public function getProxyNamespace(): string
    {
        return 'PHPChess\\Database\\Models\\Proxies';
    }

    public function getAutogenerateProxyConfiguration(): int
    {
        // TODO: Update this to AUTOGENERATE_NEVER if/when tooling to generate them is created
        return AbstractProxyFactory::AUTOGENERATE_FILE_NOT_EXISTS;
    }
}
