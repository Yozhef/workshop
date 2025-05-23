<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Redis;

use App\Domain\Entity\HomeWork;
use App\Domain\Service\HomeWorkStorageInterface;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;

final readonly class HomeWorkStorage extends AbstractRedisStorageManager implements HomeWorkStorageInterface
{
    public function __construct(string $prefix, int $ttl, ClientInterface $redis)
    {
        parent::__construct($prefix, $ttl, $redis);
    }

    public function saveHomeWork(HomeWork $homeWork): void
    {
        $this->set($homeWork->getId()->toString(), $homeWork->getTitle());
    }
}
