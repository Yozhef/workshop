<?php

declare(strict_types=1);

namespace App\Application\Command\DefaultEntity;

use App\Domain\Entity\DefaultEntity;
use App\Domain\Repository\DefaultEntityRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DefaultEntityCreateHandler
{
    public function __construct(
        private readonly DefaultEntityRepositoryInterface $defaultEntityRepository,
    ) {
    }

    public function __invoke(DefaultEntityCreate $message): void
    {
        $defaultEntity = new DefaultEntity(
            $message->id,
            $message->name,
        );

        $this->defaultEntityRepository->store($defaultEntity);
    }
}
