<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use App\Application\Command\HomeWork\Event\HomeWorkCompletedEvent;
use App\Application\Command\HomeWork\Exception\DueDateHasPassedException;
use App\Domain\Repository\HomeWorkRepositoryInterface;
use App\Domain\Service\HomeWorkStorageInterface;
use App\Infrastructure\MessageBus\EventBus;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class HomeWorkMarkCompletedHandler
{
    public function __construct(
        readonly private HomeWorkRepositoryInterface $homeWorkRepository,
        readonly private HomeWorkStorageInterface    $homeWorkStorage,
        readonly private EventBus                    $messageBus,
    )
    {
    }

    public function __invoke(HomeWorkUpdate $message): void
    {
        $homeWork = $this->homeWorkRepository->get($message->id);

        if ($homeWork->getDueDate() < new \DateTimeImmutable()) {
            throw new DueDateHasPassedException();
        }
        $homeWork->markAsCompleted();

        $this->homeWorkRepository->store($homeWork);

        $this->homeWorkStorage->setHomeWork($message->id->toString(), $message->title);

        $this->messageBus->dispatch(new HomeWorkCompletedEvent(
            $homeWork->getId(),
        ));
    }
}
