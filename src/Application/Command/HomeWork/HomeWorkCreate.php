<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use App\Infrastructure\MessageBus\CommandMessageInterface;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

readonly class HomeWorkCreate implements CommandMessageInterface
{
    public function __construct(
        public Uuid $id,
        public string $title,
        public DateTimeImmutable $dueDate
    ) {
    }
}
