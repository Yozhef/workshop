<?php

declare(strict_types=1);

namespace App\Application\Command\HomeWork;

use Symfony\Component\Uid\Uuid;

readonly class HomeWorkComplete
{
    public function __construct(public Uuid $id)
    {
    }
}
