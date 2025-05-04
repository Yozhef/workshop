<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\DefaultEntity;
use App\Domain\Repository\DefaultEntityRepositoryInterface;
use App\Infrastructure\Exception\Entity\EntityNotFoundException;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @template-extends AbstractEntityRepository<DefaultEntity>
 */
class DefaultEntityRepository extends AbstractEntityRepository implements DefaultEntityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->initServiceEntityRepository($registry, DefaultEntity::class);
    }

    public function store(DefaultEntity $defaultEntity): void
    {
        $this->getEntityManager()->persist($defaultEntity);
        $this->getEntityManager()->flush();
    }

    public function get(Uuid $id): DefaultEntity
    {
        $entity = $this->getDoctrineRepository()->find($id);

        if (!($entity instanceof DefaultEntity)) {
            throw EntityNotFoundException::fromClassNameAndIdentifier(
                DefaultEntity::class,
                [(string)$id],
            );
        }

        return $entity;
    }

    public function getPaginationList(
        int $limit,
        int $offset,
    ): DoctrinePaginator {
        $query = $this->getDoctrineRepository()->createQueryBuilder('defaultEntity')
            ->orderBy('defaultEntity.createdAt', 'DESC')
            ->getQuery();

        return $this->paginate($query, $limit, $offset);
    }
}
