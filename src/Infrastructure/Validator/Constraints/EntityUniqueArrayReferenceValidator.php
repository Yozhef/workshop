<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator\Constraints;

use App\Infrastructure\Exception\Validator\UnexpectedTypeException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EntityUniqueArrayReferenceValidator extends ConstraintValidator
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof EntityUniqueArrayReference) {
            throw new UnexpectedTypeException($constraint, EntityUniqueArrayReference::class);
        }

        if ($value === null || !is_object($value)) {
            return;
        }

        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        if (
            !$propertyAccessor->isReadable($value, $constraint->field) ||
            !$propertyAccessor->isReadable($value, $constraint->arrayField)
        ) {
            return;
        }

        $fieldValue = $propertyAccessor->getValue($value, $constraint->field);
        $arrayFieldValue = $propertyAccessor->getValue($value, $constraint->arrayField);


        if (!is_array($arrayFieldValue) || count($arrayFieldValue) === 0 || null === $fieldValue) {
            return;
        }

        $alias = 'e';
        $existingEntity = $this->entityManager->getRepository($constraint->entityClass)
            ->createQueryBuilder($alias)
            ->where(sprintf('%s.%s = :%s', $alias, $constraint->field, $constraint->field))
            ->andWhere(sprintf('%s.%s IN (:%s)', $alias, $constraint->property, $constraint->arrayField))
            ->setParameters([
                $constraint->field => $fieldValue,
                $constraint->arrayField => $arrayFieldValue,
            ])
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if ($existingEntity) {
            $this->context->buildViolation($constraint->message)
                ->setInvalidValue($fieldValue)
                ->addViolation();
        }
    }
}
