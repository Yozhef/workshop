<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use App\Infrastructure\MessageBus\CommandMessageInterface;
use Symfony\Component\Uid\Uuid;

/**
 * Created by PhpStorm.
 * User: Yarusha
 * Date: 24.05.2025
 * Time: 08:44
 */
class HomeWorkCompleted implements CommandMessageInterface
{
    public function __construct(
        public Uuid $id,
    ) {
    }
}
