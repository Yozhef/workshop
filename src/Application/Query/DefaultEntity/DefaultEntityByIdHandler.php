<?php

declare(strict_types=1);

namespace App\Application\Query\DefaultEntity;

use App\Domain\Entity\DefaultEntity;
use App\Domain\Repository\DefaultEntityRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DefaultEntityByIdHandler
{
    public function __construct(private DefaultEntityRepositoryInterface $defaultEntityRepository)
    {
    }

    public function __invoke(DefaultEntityById $message): DefaultEntity
    {
        return $this->defaultEntityRepository->get($message->id);
    }
}
