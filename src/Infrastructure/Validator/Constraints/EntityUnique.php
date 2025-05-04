<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[Attribute]
class EntityUnique extends Constraint
{
    /**
     * @var class-string
     */
    public string $entityClass;
    public string $property = 'id';
    public string $message = 'notUnique';

    public function getRequiredOptions(): array
    {
        return ['entityClass'];
    }
}
