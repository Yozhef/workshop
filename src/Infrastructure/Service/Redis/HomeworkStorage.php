<?php

namespace App\Infrastructure\Service\Redis;

use App\Domain\Service\HomeworkStorateInterface;
use Symfony\Component\Uid\Uuid;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;

final readonly class HomeworkStorage extends AbstractRedisStorageManager implements HomeworkStorateInterface
{
    public function __construct(string $prefix, int $ttl, ClientInterface $redis)
    {
        parent::__construct($prefix, $ttl, $redis);
    }

    public function setId(string|Uuid $id): void
    {
        $this->set($id, $id);
    }

    public function setName(string $name): void
    {
        $this->set($name, $name);
    }
}