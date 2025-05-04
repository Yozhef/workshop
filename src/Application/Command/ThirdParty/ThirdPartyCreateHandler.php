<?php

declare(strict_types=1);

namespace App\Application\Command\ThirdParty;

use App\Infrastructure\Service\Mailer\Client\EmailClient;
use App\Infrastructure\Service\Mailer\Dto\SendEmailEnqueueRequest;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ThirdPartyCreateHandler
{
    public function __construct(
        private readonly EmailClient $emailClient,
    ) {
    }

    public function __invoke(ThirdPartyCreate $message): void
    {
        $this->emailClient->sendEmailEnqueueRequest(new SendEmailEnqueueRequest(
            $message->event,
            $message->email,
            $message->language,
        ));
    }
}
