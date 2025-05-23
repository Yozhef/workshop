<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Redis;

use App\Domain\Service\Redis\PinStorageInterface;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;

final readonly class PinStorage extends AbstractRedisStorageManager implements PinStorageInterface
{
    public function __construct(string $prefix, int $ttl, ClientInterface $redis)
    {
        parent::__construct($prefix, $ttl, $redis);
    }

    public function setPin(string $token, string $pin): void
    {
        $this->set($token, $pin);
    }

    public function getPin(string $token): ?string
    {
        return $this->find($token);
    }

    public function deletePin(string $token): void
    {
        $this->remove($token);
    }
}
