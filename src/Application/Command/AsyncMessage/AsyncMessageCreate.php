<?php

declare(strict_types=1);

namespace App\Application\Command\AsyncMessage;

use App\Infrastructure\MessageBus\AsyncMessageInterface;
use Symfony\Component\Uid\Uuid;

readonly class AsyncMessageCreate implements AsyncMessageInterface
{
    public function __construct(
        public Uuid $id,
        public string $name,
    ) {
    }
}
