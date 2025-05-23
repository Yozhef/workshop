<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Redis;

use App\Domain\Service\Redis\HomeWorkInterface;
use Symfony\Component\Uid\Uuid;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;

final readonly class HomeWorkStorage extends AbstractRedisStorageManager implements HomeWorkInterface
{
    public function __construct(string $prefix, int $ttl, ClientInterface $redis)
    {
        parent::__construct($prefix, $ttl, $redis);
    }

    public function setHomeWork(Uuid $id, string $title): void
    {
        $this->set($id->toString(), $title);
    }

    public function findHomeWork(Uuid $id): ?string
    {
        return $this->find($id->toString());
    }

    public function deleteHomeWork(Uuid $id): void
    {
        $this->remove($id->toString());
    }
}
