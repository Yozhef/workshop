<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use App\Infrastructure\MessageBus\CommandMessageInterface;
use Symfony\Component\Uid\Uuid;

readonly class HomeWorkMarkCompleted implements CommandMessageInterface
{
    public function __construct(
        public Uuid $id,
    )
    {
    }
}
