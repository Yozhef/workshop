<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use Symfony\Component\Uid\Uuid;

interface ReferenceRepositoryInterface
{
    public function getReference(Uuid $id): mixed;
}
