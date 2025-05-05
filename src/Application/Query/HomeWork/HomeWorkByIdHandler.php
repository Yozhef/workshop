<?php

declare(strict_types=1);

namespace App\Application\Query\HomeWork;

use App\Domain\Entity\HomeWork;
use App\Domain\Repository\HomeWorkRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class HomeWorkByIdHandler
{
    public function __construct(private HomeWorkRepositoryInterface $homeWorkRepository)
    {
    }

    public function __invoke(HomeWorkById $message): HomeWork
    {
        return $this->homeWorkRepository->get($message->id);
    }
}
