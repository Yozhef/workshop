<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use Throwable;

interface ExtraParamsExceptionInterface extends Throwable
{
    /**
     * @return array<int|string, mixed>
     */
    public function getParams(): array;

    public function getKeyName(): string;
}
