<?php

declare(strict_types=1);

namespace App\Domain\Exception;

interface ParameterExceptionInterface
{
    /** @return array<mixed> */
    public function getParameters(): array;
}
