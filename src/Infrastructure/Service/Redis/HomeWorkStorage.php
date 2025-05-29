<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Redis;

use App\Domain\Service\HomeWorkStorageInterface;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;

final readonly class HomeWorkStorage extends AbstractRedisStorageManager implements HomeWorkStorageInterface
{
    public function __construct(string $prefix, int $ttl, ClientInterface $redis)
    {
        parent::__construct($prefix, $ttl, $redis);
    }

    public function setHomeWork(string $id, string $title): void
    {
        $this->set($id, $title);
    }

    public function getHomeWork(string $id): ?string
    {
        return $this->find($id);
    }

    public function deleteHomeWork(string $id): void
    {
        $this->remove($id);
    }
}
