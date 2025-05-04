<?php

declare(strict_types=1);

namespace App\Application\Command\AsyncMessage;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class AsyncMessageCreateHandler
{
    public function __invoke(AsyncMessageCreate $message): void
    {
    }
}
