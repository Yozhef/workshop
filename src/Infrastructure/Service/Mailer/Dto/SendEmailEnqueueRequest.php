<?php

declare(strict_types=1);

namespace App\Infrastructure\Service\Mailer\Dto;

class SendEmailEnqueueRequest
{
    public function __construct(
        private readonly string $event,
        private readonly string $email,
        private readonly ?string $language = null,
    ) {
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }
}
