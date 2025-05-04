<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Decorator;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository as BaseServiceEntityRepository;

/**
 * @template T of object
 *
 * @template-extends BaseServiceEntityRepository<T>
 */
final class ServiceEntityRepository extends BaseServiceEntityRepository
{
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy(
            $criteria,
            $orderBy ?? ['createdAt' => 'desc'],
            $limit,
            $offset,
        );
    }
}
