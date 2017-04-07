<?php

namespace ObservationBundle\Repository;

class ObservationRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAllNotValidated($userId)
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->where('o.user = :userId')
            ->andWhere('o.validated = :validated')
            ->setParameters(array('validated' => 0, 'userId' => $userId));
        return $qb->getQuery()
            ->getResult();
    }

    public function getAllValidated($userId)
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->where('o.user = :userId')
            ->andWhere('o.validated = :validated')
            ->setParameters(array('validated' => 1, 'userId' => $userId));
        return $qb->getQuery()
            ->getResult();
    }

    public function getAllToValidate()
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->where('o.validated = :validated')
            ->setParameter('validated', 0);
        return $qb->getQuery()
            ->getResult();
    }

    public function findAllValidatedByOiseau($oiseauId)
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->where('o.oiseau = :oiseauId')
            ->andWhere('o.validated = :validated')
            ->setParameters(array('validated' => 1, 'oiseauId' => $oiseauId));
        return $qb->getQuery()
            ->getResult();
    }
}