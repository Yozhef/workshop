<?php

declare(strict_types=1);

namespace App\UI\Response;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Serializer\Attribute as Serializer;

/** @template T */
final readonly class PaginatedResponseDto extends AbstractPaginationResponse implements ResponseInterface
{
    /** @var array<T> */
    #[Serializer\Groups(['response_dto_default'])]
    private array $data;

    public function __construct(Paginator $paginator, int $limit, int $offset)
    {
        $this->data = iterator_to_array($paginator->getIterator());

        parent::__construct($paginator, $limit, $offset);
    }

    /** @return array<T> */
    public function getData(): array
    {
        return $this->data;
    }
}
