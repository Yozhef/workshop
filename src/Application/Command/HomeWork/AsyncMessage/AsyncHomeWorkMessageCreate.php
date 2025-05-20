<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork\AsyncMessage;

use App\Infrastructure\MessageBus\AsyncMessageInterface;
use Symfony\Component\Uid\Uuid;

readonly class AsyncHomeWorkMessageCreate implements AsyncMessageInterface
{
    public function __construct(
        public Uuid $id,
        public string $title,
        public string $dueDate,
    ) {
    }
}
