<?php declare(strict_types=1);

namespace App\Application\Query\HomeworkEntity;

use App\Domain\Repository\HomeworkEntityRepositoryInterface;
use App\Infrastructure\MessageBus\QueryHandlerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class HomeworkEntityPaginatedListHandler implements QueryHandlerInterface
{
    public function __construct(
        private HomeworkEntityRepositoryInterface $defaultEntityRepository
    ) {
    }

    public function __invoke(HomeworkEntityPaginatedList $message): Paginator
    {
        return $this->defaultEntityRepository->getPaginationList(
            $message->limit,
            $message->offset,
        );
    }
}
