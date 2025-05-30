<?php declare(strict_types=1);

namespace App\Application\Query\HomeworkEntity;

use App\Domain\Entity\HomeworkEntity;
use App\Domain\Repository\HomeworkEntityRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class HomeworkEntityByIdHandler
{
    public function __construct(private HomeworkEntityRepositoryInterface $defaultEntityRepository)
    {
    }

    public function __invoke(HomeworkEntityById $message): HomeworkEntity
    {
        return $this->defaultEntityRepository->get($message->id);
    }
}
