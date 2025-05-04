<?php

declare(strict_types=1);

namespace App\Domain\Exception\Serializer;

use Symfony\Component\Serializer\Exception\RuntimeException;

final class SerializerNotSetException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Serializer not set');
    }
}
