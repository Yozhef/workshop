<?php

declare(strict_types=1);

namespace App\Application\Command\Homework;

use App\Domain\Entity\Homework;
use App\Domain\Repository\HomeworkRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use SymfonyBundles\RedisBundle\Redis\ClientInterface;

#[AsMessageHandler]
final class HomeworkCreateHandler
{
    private ClientInterface $redis;
    public function __construct(
        private readonly HomeworkRepository $repository,
        ClientInterface $redis
    ) {
        $this->redis = $redis;
    }

    public function __invoke(HomeworkCreate $message): void
    {
        $homeWork = new Homework(
            $message->id,
            $message->name,
            $message->description,
        );
        $this->redis->set((string)$homeWork->getId(), $homeWork->getName());

        $this->repository->add($homeWork);
    }
}
