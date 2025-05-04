<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
#[Attribute]
final class EntityUniqueArrayReference extends Constraint
{
    /**
     * @var class-string
     */
    public string $entityClass;
    public string $field;
    public string $arrayField;
    public string $property = 'id';
    public string $message = 'notUnique';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }

    public function getRequiredOptions(): array
    {
        return ['entityClass', 'field', 'arrayField'];
    }
}
