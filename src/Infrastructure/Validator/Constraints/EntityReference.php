<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class EntityReference extends Constraint
{
    /**
     * @var class-string
     */
    public string $entityClass;
    public string $property = 'id';
    public string $message = 'notFound';

    public function getRequiredOptions(): array
    {
        return ['entityClass'];
    }
}
