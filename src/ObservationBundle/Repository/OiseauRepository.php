<?php

namespace ObservationBundle\Repository;

class OiseauRepository extends \Doctrine\ORM\EntityRepository
{
    public function myFindAll()
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o.name', 'o.scientificName');

        return $qb->getQuery()
            ->getResult();
    }
}