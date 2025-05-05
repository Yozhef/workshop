<?php

declare(strict_types=1);

namespace App\Application\Query\HomeWork;

use App\Infrastructure\MessageBus\QueryMessageInterface;
use Symfony\Component\Uid\Uuid;

readonly class HomeWorkById implements QueryMessageInterface
{
    public function __construct(
        public Uuid $id
    ) {
    }
}
