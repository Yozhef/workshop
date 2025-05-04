<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Infrastructure\MessageBus\QueryMessageInterface;

abstract class AbstractPaginationQueryMessage implements QueryMessageInterface
{
    public function __construct(
        public int $limit,
        public int $offset
    ) {
    }
}
