<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use App\Domain\Entity\HomeWork;
use App\Domain\Repository\HomeWorkRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class HomeWorkCreateHandler
{
    public function __construct(
        private readonly HomeWorkRepositoryInterface $HomeWorkRepository,
    ) {
    }

    public function __invoke(HomeWorkCreate $message): void
    {
        $HomeWork = new HomeWork(
            $message->id,
            $message->title,
            $message->dueDate,
        );

        $this->HomeWorkRepository->store($HomeWork);
    }
}
