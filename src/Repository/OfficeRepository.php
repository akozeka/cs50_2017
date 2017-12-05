<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class OfficeRepository extends EntityRepository
{
    public function createOfficesSortedQB()
    {
        $qb = $this->createQueryBuilder('o');

        return $qb->addOrderBy('o.name', 'ASC');
    }
}
