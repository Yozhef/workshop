<?php

declare(strict_types=1);

namespace App\Infrastructure\Exception\Validator;

use Symfony\Component\Validator\Exception\UnexpectedTypeException as BaseUnexpectedTypeException;

final class UnexpectedTypeException extends BaseUnexpectedTypeException
{
}
