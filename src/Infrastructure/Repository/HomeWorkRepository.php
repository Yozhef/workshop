<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\HomeWork;
use App\Domain\Repository\HomeWorkRepositoryInterface;
use App\Infrastructure\Exception\Entity\EntityNotFoundException;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @template-extends AbstractEntityRepository<HomeWork>
 */
class HomeWorkRepository extends AbstractEntityRepository implements HomeWorkRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->initServiceEntityRepository($registry, HomeWork::class);
    }

    public function store(HomeWork $homeWork): void
    {
        $this->getEntityManager()->persist($homeWork);
        $this->getEntityManager()->flush();
    }

    public function get(Uuid $id): HomeWork
    {
        $entity = $this->getDoctrineRepository()->find($id);

        if (!($entity instanceof HomeWork)) {
            throw EntityNotFoundException::fromClassNameAndIdentifier(
                HomeWork::class,
                [(string)$id],
            );
        }

        return $entity;
    }

    public function getPaginationList(
        int $limit,
        int $offset,
    ): DoctrinePaginator {
        $query = $this->getDoctrineRepository()->createQueryBuilder('homeWork')
            ->orderBy('homeWork.createdAt', 'DESC')
            ->getQuery();

        return $this->paginate($query, $limit, $offset);
    }
}
