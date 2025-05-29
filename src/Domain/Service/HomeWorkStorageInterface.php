<?php

declare(strict_types=1);

namespace App\Domain\Service;

interface HomeWorkStorageInterface
{
    public function setHomeWork(string $id, string $title): void;

    public function getHomeWork(string $id): ?string;

    public function deleteHomeWork(string $id): void;
}
