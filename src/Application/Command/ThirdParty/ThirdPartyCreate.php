<?php

declare(strict_types=1);

namespace App\Application\Command\ThirdParty;

use App\Infrastructure\MessageBus\CommandMessageInterface;

readonly class ThirdPartyCreate implements CommandMessageInterface
{
    public function __construct(
        public string $event,
        public string $email,
        public ?string $language = null,
    ) {
    }
}
