<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use App\Domain\Entity\HomeWork;
use App\Domain\Repository\HomeWorkRepositoryInterface;
use App\Domain\Service\HomeWorkStorageInterface;
use App\Infrastructure\MessageBus\CommandBus;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\ExceptionInterface;

#[AsMessageHandler]
final readonly class HomeWorkCreateHandler
{
    public function __construct(
        private HomeWorkRepositoryInterface $homeWorkRepository,
        private HomeWorkStorageInterface $homeWorkStorage,
        private CommandBus $queryBus,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function __invoke(HomeWorkCreate $message): void
    {
        $homeWork = new HomeWork(
            $message->id,
            $message->name,
            $message->dueDate,
        );

        $this->homeWorkRepository->store($homeWork);
        $this->homeWorkStorage->saveHomeWork($homeWork);
        $this->queryBus->dispatch(
            new HomeWorkCreateMessage(
                $homeWork->getId(),
                $homeWork->getTitle(),
                $homeWork->getDueDate(),
            ),
        );
    }
}
