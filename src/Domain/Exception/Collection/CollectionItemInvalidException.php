<?php

declare(strict_types=1);

namespace App\Domain\Exception\Collection;

class CollectionItemInvalidException extends CollectionException
{
    public function __construct()
    {
        parent::__construct('collection.invalid_item');
    }
}
