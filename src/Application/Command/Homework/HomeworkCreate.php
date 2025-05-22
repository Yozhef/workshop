<?php

namespace App\Application\Command\Homework;

use App\Infrastructure\MessageBus\CommandMessageInterface;
use Symfony\Component\Uid\Uuid;

class HomeworkCreate implements CommandMessageInterface
{
    public function __construct(
        public Uuid $id,
        public string $name,
        public ?string $description = null,
    ) {
    }
}