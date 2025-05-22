<?php

namespace App\Domain\Service;

use Symfony\Component\Uid\Uuid;

interface HomeworkStorateInterface
{
    public function setId(string|Uuid $id);
    public function setName(string $name);
}
