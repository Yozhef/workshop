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

    public function setHomeWork(string $token, string $pin): void
    {
        $this->set($token, $pin);
    }

    public function getHomeWork(string $token): ?string
    {
        return $this->find($token);
    }

    public function deleteHomeWork(string $token): void
    {
        $this->remove($token);
    }
}
