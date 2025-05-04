<?php

declare(strict_types=1);

namespace App\Application\Command\DefaultEntity;

use App\Domain\Repository\DefaultEntityRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DefaultEntityUpdateHandler
{
    public function __construct(
        private readonly DefaultEntityRepositoryInterface $defaultEntityRepository,
    ) {
    }

    public function __invoke(DefaultEntityUpdate $message): void
    {
        $defaultEntity = $this->defaultEntityRepository->get($message->id);

        $defaultEntity
            ->setName($message->name);

        $this->defaultEntityRepository->store($defaultEntity);
    }
}
