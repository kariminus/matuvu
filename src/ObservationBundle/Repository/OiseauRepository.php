<?php

namespace ObservationBundle\Repository;

class OiseauRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllDistinct()
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o.name')
            ->distinct(true);


        return $qb->getQuery()
            ->getResult();
    }
}