<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    public function getAllCategories()
    {
        $query = $this->getEntityManager()->createQuery('SELECT c FROM AppBundle:Category c ORDER BY c.id DESC');
        return $query;
    }
}
