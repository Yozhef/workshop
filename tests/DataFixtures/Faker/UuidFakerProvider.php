<?php

declare(strict_types=1);

namespace App\Tests\DataFixtures\Faker;

use Symfony\Component\Uid\Uuid;

class UuidFakerProvider implements FakerProviderInterface
{
    public static function uuid(string $uuid): Uuid
    {
        return Uuid::fromString($uuid);
    }
}
