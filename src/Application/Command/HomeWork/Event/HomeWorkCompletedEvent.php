<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork\Event;

use App\Infrastructure\MessageBus\AsyncMessageInterface;
use Symfony\Component\Uid\Uuid;

readonly class HomeWorkCompletedEvent implements AsyncMessageInterface
{
    public function __construct(
        public Uuid $id,
    )
    {
    }
}
