<?php

declare(strict_types=1);

namespace App\Application\Command\PinCode;

use App\Infrastructure\MessageBus\CommandMessageInterface;
use Symfony\Component\Uid\Uuid;

readonly class PinCodeCreate implements CommandMessageInterface
{
    public function __construct(
        public Uuid $token,
    ) {
    }
}
