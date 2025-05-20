<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork\AsyncMessage;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class AsyncHomeWorkMessageCreateHandler
{
    public function __invoke(AsyncHomeWorkMessageCreate $message): void
    {
    }
}
