<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator\Constraints;

use App\Infrastructure\Exception\Validator\UnexpectedTypeException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EntityReferenceValidator extends ConstraintValidator
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof EntityReference) {
            throw new UnexpectedTypeException($constraint, EntityReference::class);
        }

        if ($value === null) {
            return;
        }

        $found = (bool) $this->entityManager->getRepository($constraint->entityClass)->findOneBy([
            $constraint->property => $value,
        ]);

        if (!$found) {
            $this->context->addViolation($constraint->message);
        }
    }
}
