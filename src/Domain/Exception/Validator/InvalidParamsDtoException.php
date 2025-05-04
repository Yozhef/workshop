<?php

declare(strict_types=1);

namespace App\Domain\Exception\Validator;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class InvalidParamsDtoException extends InvalidParamsException
{
    private readonly string $dtoClassName;

    public function __construct(ConstraintViolationListInterface $list, string $dtoClassName)
    {
        $this->dtoClassName = $dtoClassName;

        parent::__construct($list);
    }

    public function getDtoClassName(): string
    {
        return $this->dtoClassName;
    }
}
