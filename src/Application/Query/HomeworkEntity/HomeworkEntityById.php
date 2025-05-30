<?php

declare(strict_types=1);

namespace App\Application\Query\HomeworkEntity;

use App\Infrastructure\MessageBus\QueryMessageInterface;
use Symfony\Component\Uid\Uuid;

readonly class HomeworkEntityById implements QueryMessageInterface
{
    public function __construct(
        public Uuid $id
    ) {
    }
}
