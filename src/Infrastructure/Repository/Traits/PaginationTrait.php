<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Traits;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\CountWalker;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;

trait PaginationTrait
{
    public function paginate(
        Query $query,
        int $limit,
        int $offset
    ): DoctrinePaginator {
        $query->setHint(CountWalker::HINT_DISTINCT, false);

        $paginator = new DoctrinePaginator($query, false);
        $paginator->setUseOutputWalkers(false);

        $paginator->getQuery()
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $paginator;
    }
}
