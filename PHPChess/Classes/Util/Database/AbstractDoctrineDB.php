<?php

declare(strict_types=1);

namespace PHPChess\Util\Database;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\ChainCache;
use Doctrine\Common\Cache\RedisCache;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use PHPChess\Util\Database\Config\AbstractDoctrineDBConfig;

abstract class AbstractDoctrineDB extends AbstractDB
{
    private EntityManager $entityManager;

    public function __construct()
    {
        $redis = new \Redis();
        $redis->connect($_ENV['REDIS_HOST']);
        $redis->select((int) $_ENV['REDIS_DATABASE']);
        $redisCache = new RedisCache();
        $redisCache->setRedis($redis);
        $cache = new ChainCache(
            [
                new ArrayCache(),
                $redisCache,
            ]
        );
        $databaseConfig = $this->getConfig();
        $entityManagerConfiguration = new Configuration();
        // Setup the cache
        $entityManagerConfiguration->setResultCacheImpl($cache);
        $entityManagerConfiguration->setQueryCacheImpl($cache);
        // Set the proxy directory
        $entityManagerConfiguration->setProxyDir($databaseConfig->getProxyDirectory());
        $entityManagerConfiguration->setProxyNamespace($databaseConfig->getProxyNamespace());
        $entityManagerConfiguration->setAutoGenerateProxyClasses($databaseConfig->getAutogenerateProxyConfiguration());
        // Set the naming strategy
        $entityManagerConfiguration->setNamingStrategy(new UnderscoreNamingStrategy(CASE_LOWER, true));
        // Setup the annotation driver
        $metadataDriver = $entityManagerConfiguration->newDefaultAnnotationDriver($databaseConfig->getModelPaths(), false);
        $entityManagerConfiguration->setMetadataDriverImpl($metadataDriver);

        $this->entityManager = EntityManager::create(
            $databaseConfig->getConfigArray(),
            $entityManagerConfiguration,
        );
    }

    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    public function getPDO(): Connection
    {
        return $this->getEntityManager()->getConnection();
    }

    abstract public function getConfig(): AbstractDoctrineDBConfig;
}
