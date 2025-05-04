<?php

declare(strict_types=1);

namespace App\UI\Response;

use Symfony\Component\Serializer\Attribute as Serializer;

/** @template T */
final readonly class ResponseDto implements ResponseInterface
{
    /** @var T */
    #[Serializer\Groups(['response_dto_default'])]
    private mixed $data;

    /** @param T $data */
    public function __construct(mixed $data)
    {
        $this->data = $data;
    }

    /** @return T */
    public function getData(): mixed
    {
        return $this->data;
    }
}
