<?php

declare(strict_types=1);

namespace App\Domain\Service\Redis;

interface PinStorageInterface
{
    public function setPin(string $token, string $pin): void;

    public function getPin(string $token): ?string;

    public function deletePin(string $token): void;
}
