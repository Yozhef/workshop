<?php

namespace App\Application\Command\HomeWork;

use App\Message\NotifyHomeworkCreated;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class NotifyHomeworkHandler
{
    public function __invoke(NotifyHomeworkCreated $message)
    {
    }
}

