<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use App\Application\Command\HomeWork\Event\HomeWorkCreatedEvent;
use App\Domain\Entity\HomeWork;
use App\Domain\Repository\HomeWorkRepositoryInterface;
use App\Domain\Service\HomeWorkStorageInterface;
use App\Infrastructure\MessageBus\EventBus;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class HomeWorkCreateHandler
{
    public function __construct(
        readonly private HomeWorkRepositoryInterface $homeWorkRepository,
        readonly private HomeWorkStorageInterface    $homeWorkStorage,
        readonly private EventBus                  $messageBus,
    )
    {
    }

    public function __invoke(HomeWorkCreateCommand $message): void
    {
        $homeWork = new HomeWork(
            $message->id,
            $message->title,
            $message->dueDate,
        );

        $this->homeWorkRepository->store($homeWork);

        $this->homeWorkStorage->setHomeWork($message->id->toString(), $message->title);

        $this->messageBus->dispatch(new HomeWorkCreatedEvent(
            $homeWork->getId(),
            $homeWork->getTitle(),
            $homeWork->getDueDate(),
        ));
    }
}
