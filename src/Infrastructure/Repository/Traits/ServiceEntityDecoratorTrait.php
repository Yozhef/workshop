<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Traits;

use App\Infrastructure\Repository\Decorator\ServiceEntityRepository;
use App\Infrastructure\Repository\Exception\InvalidEntityManagerForEntityException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository as VendorServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template T of object
 */
trait ServiceEntityDecoratorTrait
{
    /**
     * @var VendorServiceEntityRepository<T>
     */
    private VendorServiceEntityRepository $doctrineRepository;

    private EntityManagerInterface $entityManager;

    /**
     * @param class-string<T> $entityClassName
     */
    protected function initServiceEntityRepository(ManagerRegistry $registry, string $entityClassName): void
    {
        $this->doctrineRepository = $this->createDoctrineRepository($registry, $entityClassName);
        $this->entityManager = $this->getEntityManagerForEntity($registry, $entityClassName);
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @return VendorServiceEntityRepository<T>
     */
    protected function getDoctrineRepository(): VendorServiceEntityRepository
    {
        return $this->doctrineRepository;
    }

    /**
     * @param class-string<T> $entityClassName
     *
     * @return VendorServiceEntityRepository<T>
     */
    private function createDoctrineRepository(
        ManagerRegistry $registry,
        string $entityClassName,
    ): VendorServiceEntityRepository {
        // @phpstan-ignore-next-line
        return new ServiceEntityRepository($registry, $entityClassName);
    }

    /**
     * @param class-string<T> $entityClassName
     */
    private function getEntityManagerForEntity(
        ManagerRegistry $registry,
        string $entityClassName,
    ): EntityManagerInterface {
        $entityManager = $registry->getManagerForClass($entityClassName);

        if (!$entityManager instanceof EntityManagerInterface) {
            throw new InvalidEntityManagerForEntityException(
                sprintf(
                    'Invalid entity manager for %s entity. Expected %s, %s given',
                    $entityClassName,
                    EntityManagerInterface::class,
                    !is_object($entityManager) ? gettype($entityManager) : $entityManager::class,
                ),
            );
        }

        return $entityManager;
    }
}
