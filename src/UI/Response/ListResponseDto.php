<?php

declare(strict_types=1);

namespace App\UI\Response;

use Symfony\Component\Serializer\Attribute as Serializer;

/** @template T */
final readonly class ListResponseDto implements ResponseInterface
{
    /** @var array<T> */
    #[Serializer\Groups(['response_dto_default'])]
    private array $data;

    /** @param iterable<T> $data */
    public function __construct(iterable $data)
    {
        $this->data = iterator_to_array($data);
    }

    /** @return array<T> */
    public function getData(): array
    {
        return $this->data;
    }
}
