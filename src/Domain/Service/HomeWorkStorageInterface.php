<?php

declare(strict_types=1);

namespace App\Domain\Service;

interface HomeWorkStorageInterface
{
    public function setHomeWorkId(string $id): void;
}
