<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class AsyncHomeWorkCreateHandler
{
    public function __invoke(AsyncHomeWorkCreate $homeWork): void
    {
    }
}
