<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;
use App\Domain\Repository\HomeWorkRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Created by PhpStorm.
 * User: Yarusha
 * Date: 24.05.2025
 * Time: 08:44
 */

class HomeWorkCompletedHandler
{
    public function __construct(
        private readonly HomeWorkRepositoryInterface $homeWorkRepository,
    ) {
    }

    public function __invoke(HomeWorkCompleted $message): void
    {
        $defaultEntity = $this->homeWorkRepository->get($message->id);

        $defaultEntity->complete();

        $this->homeWorkRepository->store($defaultEntity);
    }
}
