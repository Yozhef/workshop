<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork\Exception;

class DueDateHasPassedException extends \DomainException
{
    public function __construct(
        string     $message = 'Cannot mark homework as completed, due date has passed.',
        int        $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}
