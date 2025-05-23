<?php

declare(strict_types=1);

namespace App\Application\Command\PinCode;

use App\Domain\Service\Redis\PinStorageInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class PinCodeCreateHandler
{
    public function __construct(
        private readonly PinStorageInterface $pinStorage,
    ) {
    }

    public function __invoke(PinCodeCreate $message): void
    {
        $this->pinStorage->setPin($message->token->toString(), (string) rand(100, 999));
    }
}
