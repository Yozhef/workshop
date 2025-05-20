<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use App\Domain\Entity\HomeWork;
use App\Domain\Repository\HomeWorkRepositoryInterface;
use App\Domain\Service\HomeWorkStorageInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class HomeWorkCreateHandler
{
    public function __construct(
        private readonly HomeWorkRepositoryInterface $homeWorkRepository,
        private readonly HomeWorkStorageInterface $homeWorkStorage,
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

        $this->homeWorkStorage->setHomeWorkId($message->id->toString());
    }
}
