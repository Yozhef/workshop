<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\HomeWork;

interface HomeWorkStorageInterface
{
    public function saveHomeWork(HomeWork $homeWork): void;
}
