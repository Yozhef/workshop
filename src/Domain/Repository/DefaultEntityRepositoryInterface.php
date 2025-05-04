<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\DefaultEntity;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Symfony\Component\Uid\Uuid;

interface DefaultEntityRepositoryInterface
{
    public function store(DefaultEntity $defaultEntity): void;

    public function get(Uuid $id): DefaultEntity;

    public function getPaginationList(int $limit, int $offset): DoctrinePaginator;

    public function getReference(Uuid $id): mixed;
}
