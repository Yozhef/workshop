<?php

declare(strict_types=1);

namespace App\Infrastructure\Exception\Entity;

use Doctrine\ORM\EntityNotFoundException as ORMEntityNotFoundException;

final class EntityNotFoundException extends ORMEntityNotFoundException
{
    /**
     * @param string $className
     */
    public static function fromClassNameAndIdentifier($className, array $id): self
    {
        $ids = [];

        foreach ($id as $key => $value) {
            $ids[] = $key . '(' . $value . ')';
        }

        return new self(
            'Entity of type \'' . $className . '\'' .
            (0 !== count($ids) ? ' for IDs ' . implode(', ', $ids) : '') . ' was not found',
        );
    }
}
