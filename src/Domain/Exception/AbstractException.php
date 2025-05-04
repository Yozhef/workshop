<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Exception;
use Throwable;

abstract class AbstractException extends Exception implements ParameterExceptionInterface
{
    /** @param array<mixed> $parameters */
    public function __construct(
        string $message,
        private readonly array $parameters = [],
        int $code = 422,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /** @return array<mixed> */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
