<?php

declare(strict_types=1);

namespace App\Domain\Service\Redis;

use Symfony\Component\Uid\Uuid;

interface HomeWorkInterface
{
    public function setHomeWork(Uuid $id, string $title): void;

    public function findHomeWork(Uuid $id): ?string;

    public function deleteHomeWork(Uuid $id): void;
}
