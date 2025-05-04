<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Redis;

use SymfonyBundles\RedisBundle\Redis\ClientInterface;

abstract readonly class AbstractRedisStorageManager
{
    public function __construct(private string $prefix, private int $ttl, private ClientInterface $redis)
    {
    }

    public function find(string $key): ?string
    {
        return $this->redis->get($this->getRedisKey($key));
    }

    public function set(string $key, string $value): void
    {
        $key = $this->getRedisKey($key);

        $this->redis->setex($key, $this->ttl, $value);
    }

    public function remove(string $key): void
    {
        $this->redis->remove($this->getRedisKey($key));
    }

    private function getRedisKey(string $key): string
    {
        return sprintf('%s.%s', $this->prefix, $key);
    }
}
