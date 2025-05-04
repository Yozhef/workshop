<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator\Constraints;

use App\Infrastructure\Exception\Validator\UnexpectedTypeException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * A ConstraintValidator that provides a method to get the value of any form field by dot notation.
 */
abstract class AbstractFormFieldConstraintValidator extends ConstraintValidator
{
    public const string THIS = '$this';

    /**
     * Get the form field value by dot notation
     */
    protected function getFieldValue(string $field): mixed
    {
        if ($field === self::THIS) {
            return $this->context->getValue();
        }

        $form = $this->context->getRoot();
        if (!($form instanceof FormInterface)) {
            throw new UnexpectedTypeException($form, FormInterface::class);
        }

        foreach (explode('.', $field) as $nextFieldPath) {
            $form = $form->get($nextFieldPath);
        }

        return $form->getData();
    }
}
