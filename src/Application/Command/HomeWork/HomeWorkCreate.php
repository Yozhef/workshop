<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use App\Infrastructure\MessageBus\CommandMessageInterface;
use Symfony\Component\Uid\Uuid;
use DateTimeImmutable;

/**
 * Created by PhpStorm.
 * User: Yarusha
 * Date: 24.05.2025
 * Time: 07:17
 */
readonly class HomeWorkCreate implements CommandMessageInterface
{
    public function __construct(
        public Uuid $id,
        public string $title,
        public DateTimeImmutable $dueDate,
        public bool $isCompleted,
    ) {
    }
}
