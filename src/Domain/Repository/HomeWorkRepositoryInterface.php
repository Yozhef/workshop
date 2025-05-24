<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\HomeWork;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Symfony\Component\Uid\Uuid;

interface HomeWorkRepositoryInterface
{
    public function store(HomeWork $homeWork): void;

    public function get(Uuid $id): HomeWork;

    public function getPaginationList(int $limit, int $offset): DoctrinePaginator;

    public function getReference(Uuid $id): mixed;
}
