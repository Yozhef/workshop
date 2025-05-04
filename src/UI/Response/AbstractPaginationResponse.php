<?php

declare(strict_types=1);

namespace App\UI\Response;

use App\UI\Response\Model\PaginationModel;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Symfony\Component\Serializer\Attribute as Serializer;

abstract readonly class AbstractPaginationResponse implements ResponseInterface
{
    #[Serializer\Groups(['pagination_default'])]
    private PaginationModel $pagination;

    public function __construct(DoctrinePaginator $paginator, int $limit, int $offset)
    {
        $this->pagination = new PaginationModel($paginator, $limit, $offset);
    }

    public function getPagination(): PaginationModel
    {
        return $this->pagination;
    }
}
