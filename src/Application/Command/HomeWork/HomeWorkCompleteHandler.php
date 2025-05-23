<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use App\Application\Exception\Command\HomeWork\HomeWorkDeadlinePassedException;
use App\Domain\Repository\HomeWorkRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class HomeWorkCompleteHandler
{
    public function __construct(private HomeWorkRepositoryInterface $homeWorkRepository)
    {
    }

    public function __invoke(HomeWorkComplete $homeWorkComplete): void
    {
        $homeWork = $this->homeWorkRepository->get($homeWorkComplete->id);

        if ($homeWork->getDueDate() < new \DateTimeImmutable()) {
            throw new HomeWorkDeadlinePassedException('The homework deadline has passed');
        }

        $homeWork->setIsCompleted(true);
        $this->homeWorkRepository->store($homeWork);
    }
}
