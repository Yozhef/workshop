<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use App\Domain\Entity\HomeWork;
use App\Domain\Repository\HomeWorkRepositoryInterface;
use App\Domain\Service\HomeWorkStorageInterface;
use App\Message\NotifyHomeworkCreated;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final readonly class HomeWorkCreateHandler
{
    public function __construct(
        private HomeWorkRepositoryInterface $HomeWorkRepository,
        private HomeWorkStorageInterface $HomeWorkStorage,
        private MessageBusInterface $messageBus,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function __invoke(HomeWorkCreate $message): void
    {
        $HomeWork = new HomeWork(
            $message->id,
            $message->title,
            $message->dueDate,
        );

        $this->HomeWorkRepository->store($HomeWork);
        $this->HomeWorkStorage->setHomeWork(
            $HomeWork->getId()->toString(),
            $HomeWork->getTitle()
        );
        $this->messageBus->dispatch(new NotifyHomeworkCreated($HomeWork->getId(), $HomeWork->getTitle()));
    }
}
