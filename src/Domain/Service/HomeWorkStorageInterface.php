<?php

declare(strict_types=1);

namespace App\Domain\Service;

interface HomeWorkStorageInterface
{
    public function setHomeWork(string $token, string $pin): void;

    public function getHomeWork(string $token): ?string;

    public function deleteHomeWork(string $token): void;
}
