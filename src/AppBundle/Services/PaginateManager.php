<?php

namespace AppBundle\Services;

use Doctrine\ORM\Tools\Pagination\Paginator;

class PaginateManager
{
    /**
     * @var int $limit
     */
    public $limit;

    public function __construct($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @param $dql
     * @param int $page
     * @return array|Paginator
     */
    public function paginate($dql, $page = 1)
    {
        $pagination = new Paginator($dql);
        $limit = $this->limit;
        $pagination->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);
        return $pagination;
    }
}