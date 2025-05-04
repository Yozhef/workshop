<?php

declare(strict_types=1);

namespace App\UI\Response\Model;

use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Symfony\Component\Serializer\Attribute as Serializer;

final class PaginationModel
{
    #[Serializer\Groups(['pagination_default'])]
    private int $perPage;

    #[Serializer\Groups(['pagination_default'])]
    private int $pagesCount;

    #[Serializer\Groups(['pagination_default'])]
    private int $currentPage;

    #[Serializer\Groups(['pagination_default'])]
    private int $elementsCount;

    public function __construct(DoctrinePaginator $paginator, int $limit, int $offset)
    {
        $this->perPage = $limit;
        $this->pagesCount = (int) ceil($paginator->count() / $limit);
        $this->currentPage = (int) ceil($offset / $limit) + 1;
        $this->elementsCount = $paginator->count();
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getPagesCount(): int
    {
        return $this->pagesCount;
    }

    public function getElementsCount(): int
    {
        return $this->elementsCount;
    }
}
