<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Repository\ReferenceRepositoryInterface;
use App\Infrastructure\Repository\Traits\PaginationTrait;
use App\Infrastructure\Repository\Traits\ServiceEntityDecoratorTrait;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\Uid\Uuid;

/**
 * @template T of object
 */
abstract class AbstractEntityRepository implements ReferenceRepositoryInterface
{
    use PaginationTrait;

    /**
     * @use ServiceEntityDecoratorTrait<T>
     * @phpstan-use ServiceEntityDecoratorTrait<T>
     */
    use ServiceEntityDecoratorTrait;

    /**
     * @return ?object
     *
     * @throws ORMException
     */
    public function getReference(Uuid $id): mixed
    {
        /** @var class-string<object> $className */
        $className = $this->getDoctrineRepository()->getClassName();

        return $this->getEntityManager()->getReference(
            $className,
            $id,
        );
    }
}
