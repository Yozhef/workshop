<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use App\Domain\Entity\HomeWork;
use App\Domain\Repository\HomeWorkRepositoryInterface;
use App\Domain\Service\Redis\HomeWorkInterface;
use App\Infrastructure\MessageBus\CommandBus;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class HomeWorkCreateHandler
{
    public function __construct(
        private readonly HomeWorkRepositoryInterface $homeWorkRepository,
        private readonly HomeWorkInterface $homeWorkStorage,
        private readonly CommandBus $commandBus
    ) {
    }

    public function __invoke(HomeWorkCreate $message): void
    {
        $homeWork = new HomeWork(
            $message->id,
            $message->title,
            $message->dueDate,
        );

        $this->homeWorkRepository->store($homeWork);

        $this->homeWorkStorage->setHomeWork($homeWork->getId(), $homeWork->getTitle());

        $this->commandBus->dispatch(new AsyncHomeWorkCreate(
            $homeWork->getId(),
            $homeWork->getTitle(),
            $homeWork->getDueDate(),
        ));
    }
}
