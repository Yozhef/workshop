<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use App\Application\Command\AsyncMessage\AsyncMessageCreate;
use App\Domain\Entity\DefaultEntity;
use App\Domain\Entity\HomeWork;
use App\Domain\Repository\DefaultEntityRepositoryInterface;
use App\Domain\Repository\HomeWorkRepositoryInterface;
use App\Domain\Service\HomeWorkStorageInterface;
use App\Infrastructure\MessageBus\CommandBus;
use App\Infrastructure\MessageBus\QueryBus;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly final class HomeWorkCompleteHandler
{
    public function __construct(
        private HomeWorkRepositoryInterface $homeWorkRepository,
    ) {
    }

    public function __invoke(HomeWorkComplete $message): void
    {
        $entity = $this->homeWorkRepository->get($message->id);

        try {
            $entity->complete(new \DateTimeImmutable());
            $this->homeWorkRepository->store($entity);
        } catch (\DomainException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
