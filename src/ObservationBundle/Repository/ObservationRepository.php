<?php

namespace ObservationBundle\Repository;

class ObservationRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     *  Compte le nombre d'observation unique d'un utilisateur sur un oiseau
     * @param $userId
     * @param $oiseauId
     * @return mixed
     */
    public function findDistinct($userId, $oiseauId)
    {
        $qb = $this->createQueryBuilder('o')
            ->select('count(o)')
            ->where('o.user = :userId')
            ->andWhere('o.oiseau = :oiseauId')
            ->andWhere('o.validated = :validated')
            ->setParameters(array('userId' => $userId, 'oiseauId' => $oiseauId, 'validated' => 1))
            ->distinct();
        return $qb->getQuery()
            ->getSingleScalarResult();

    }

    public function findImage($oiseauId)
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->where('o.oiseau = :oiseauId')
            ->andWhere('o.validated = :validated')
            ->andWhere('o.imageName is NOT NULL')
            ->setParameters(array('validated' => 1, 'oiseauId' => $oiseauId ));


        try {
            return $qb->getQuery()
                ->getOneOrNullResult();
        }
        catch(\Doctrine\ORM\NoResultException $e) {
            return $qb[0];
        }

    }
}