<?php

declare(strict_types=1);

namespace App\Application\Query\HomeWork;

use App\Domain\Repository\HomeWorkRepositoryInterface;
use App\Infrastructure\MessageBus\QueryHandlerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class HomeWorkPaginatedListHandler implements QueryHandlerInterface
{
    public function __construct(
        private HomeWorkRepositoryInterface $homeWorkRepository
    ) {
    }

    public function __invoke(HomeWorkPaginatedList $message): Paginator
    {
        return $this->homeWorkRepository->getPaginationList(
            $message->limit,
            $message->offset,
        );
    }
}
