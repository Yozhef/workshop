<?php

declare(strict_types=1);

namespace App\Application\Command\DefaultEntity;

use App\Infrastructure\MessageBus\CommandMessageInterface;
use Symfony\Component\Uid\Uuid;

readonly class DefaultEntityCreate implements CommandMessageInterface
{
    public function __construct(
        public Uuid $id,
        public string $name
    ) {
    }
}
