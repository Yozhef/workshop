<?php

declare(strict_types=1);

namespace App\Application\Query\DefaultEntity;

use App\Domain\Repository\DefaultEntityRepositoryInterface;
use App\Infrastructure\MessageBus\QueryHandlerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class DefaultEntityPaginatedListHandler implements QueryHandlerInterface
{
    public function __construct(
        private DefaultEntityRepositoryInterface $defaultEntityRepository
    ) {
    }

    public function __invoke(DefaultEntityPaginatedList $message): Paginator
    {
        return $this->defaultEntityRepository->getPaginationList(
            $message->limit,
            $message->offset,
        );
    }
}
