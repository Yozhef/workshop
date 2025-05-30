<?php declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\HomeworkEntity;
use App\Domain\Repository\HomeworkEntityRepositoryInterface;
use App\Infrastructure\Exception\Entity\EntityNotFoundException;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class HomeworkEntityRepository extends AbstractEntityRepository implements HomeworkEntityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        $this->initServiceEntityRepository($registry, HomeworkEntity::class);
    }

    public function store(HomeworkEntity $defaultEntity): void
    {
        $this->getEntityManager()->persist($defaultEntity);
        $this->getEntityManager()->flush();
    }

    public function get(Uuid $id): HomeworkEntity
    {
        $entity = $this->getDoctrineRepository()->find($id);

        if (!($entity instanceof HomeworkEntity)) {
            throw EntityNotFoundException::fromClassNameAndIdentifier(
                HomeworkEntity::class,
                [(string)$id],
            );
        }

        return $entity;
    }

    public function getPaginationList(
        int $limit,
        int $offset,
    ): DoctrinePaginator {
        $query = $this->getDoctrineRepository()->createQueryBuilder('homeworkEntity')
            ->orderBy('homeworkEntity.createdAt', 'DESC')
            ->getQuery();

        return $this->paginate($query, $limit, $offset);
    }
}