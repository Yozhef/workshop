<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use App\Domain\Entity\HomeWork;
use App\Domain\Repository\HomeWorkRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Created by PhpStorm.
 * User: Yarusha
 * Date: 24.05.2025
 * Time: 07:18
 */
#[AsMessageHandler]
final class HomeWorkCreateHandler
{
    public function __construct(
        private readonly HomeWorkRepositoryInterface $homeWorkRepository,
    ) {
    }

    public function __invoke(HomeWorkCreate $message): void
    {
        $homeWorkEntity = new HomeWork(
            $message->id,
            $message->title,
            $message->dueDate,
        );

        $this->homeWorkRepository->store($homeWorkEntity);
    }
}
