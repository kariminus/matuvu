<?php

namespace ObservationBundle\Repository;

class ObservationRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Récupére toutes les obsevations pas encore validées
     * @param $userId
     * @return array
     *
     */
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

    /**
     * Récupére toutes les observations validées
     * @param $userId
     * @return array
     *
     */
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

    /**
     * Récupére toutes les observations qui doivent être validée
     * @return array
     *
     */
    public function getAllToValidate()
    {
        $qb = $this->createQueryBuilder('o')
            ->select('o')
            ->where('o.validated = :validated')
            ->setParameter('validated', 0);
        return $qb->getQuery()
            ->getResult();
    }

    /**
     * Récupére toutes les observations validées d'un oiseau
     * @param $oiseauId
     * @return array
     */
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
}