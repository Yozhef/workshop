<?php

declare(strict_types=1);

namespace App\UI\Response;

use Exception;

final class InvalidResponseDataTypeException extends Exception
{
    public function __construct(mixed $payload)
    {
        parent::__construct(sprintf('Invalid response data type: %s', gettype($payload)));
    }
}
