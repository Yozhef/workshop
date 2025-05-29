<?php

namespace App\Message;

use Symfony\Component\Uid\Uuid;

readonly class NotifyHomeworkCreated
{
    public function __construct(
        public Uuid $id,
        public string $title,
    ) {}
}
