<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use App\Application\Command\AsyncMessage\AsyncMessageCreate;
use App\Domain\Entity\DefaultEntity;
use App\Domain\Entity\HomeWork;
use App\Domain\Repository\DefaultEntityRepositoryInterface;
use App\Domain\Repository\HomeWorkRepositoryInterface;
use App\Domain\Service\HomeWorkStorageInterface;
use App\Infrastructure\MessageBus\CommandBus;
use App\Infrastructure\MessageBus\QueryBus;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly final class HomeWorkCreateHandler
{
    public function __construct(
        private HomeWorkRepositoryInterface $homeWorkRepository,
        private HomeWorkStorageInterface $homeWorkStorage,
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(HomeWorkCreate $message): void
    {
        $this->homeWorkRepository->store(new HomeWork(
            $message->id,
            $message->title,
            \DateTimeImmutable::createFromTimestamp($message->dueDate),
        ));

        $this->homeWorkStorage->setHomeWork($message->id->toString());

        $this->commandBus->dispatch(new AsyncMessageCreate($message->id, 'home-work'));
    }
}
