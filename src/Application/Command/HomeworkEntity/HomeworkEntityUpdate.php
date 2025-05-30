<?php

declare(strict_types=1);

namespace App\Application\Command\HomeworkEntity;

use App\Infrastructure\MessageBus\CommandMessageInterface;
use Symfony\Component\Uid\Uuid;

readonly class HomeworkEntityUpdate implements CommandMessageInterface
{
    public function __construct(
        public Uuid $id,
        public string $title,
        public string $description,
    ) {
    }
}
