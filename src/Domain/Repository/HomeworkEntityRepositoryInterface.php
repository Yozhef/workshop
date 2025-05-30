<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\HomeworkEntity;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Symfony\Component\Uid\Uuid;

interface HomeworkEntityRepositoryInterface
{
    public function store(HomeworkEntity $defaultEntity): void;

    public function get(Uuid $id): HomeworkEntity;

    public function getPaginationList(int $limit, int $offset): DoctrinePaginator;

    public function getReference(Uuid $id): mixed;
}