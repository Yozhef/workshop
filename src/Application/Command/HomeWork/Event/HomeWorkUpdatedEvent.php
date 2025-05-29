<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork\Event;

use App\Infrastructure\MessageBus\AsyncMessageInterface;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

readonly class HomeWorkUpdatedEvent implements AsyncMessageInterface
{
    public function __construct(
        public Uuid              $id,
        public string            $title,
        public DateTimeImmutable $dueDate,
        public bool              $completed
    )
    {
    }
}
