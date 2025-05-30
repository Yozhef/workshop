<?php

declare(strict_types=1);

namespace App\Application\Command\HomeworkEntity;

use App\Domain\Repository\HomeworkEntityRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class HomeworkEntityUpdateHandler
{
    public function __construct(
        private readonly HomeworkEntityRepositoryInterface $defaultEntityRepository,
    ) {
    }

    public function __invoke(HomeworkEntityUpdate $message): void
    {
        $defaultEntity = $this->defaultEntityRepository->get($message->id);

        $defaultEntity
            ->setName($message->name);

        $this->defaultEntityRepository->store($defaultEntity);
    }
}
