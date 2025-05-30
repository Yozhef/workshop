<?php

declare(strict_types=1);

namespace App\Application\Command\HomeworkEntity;

use App\Domain\Entity\HomeworkEntity;
use App\Domain\Repository\HomeworkEntityRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class HomeworkEntityCreateHandler
{
    public function __construct(
        private readonly HomeworkEntityRepositoryInterface $defaultEntityRepository,
    ) {
    }

    public function __invoke(HomeworkEntityCreate $message): void
    {
        $defaultEntity = new HomeworkEntity(
            $message->id,
            $message->title,
            $message->description,
        );

        $this->defaultEntityRepository->store($defaultEntity);
    }
}
