<?php

namespace App\Repository;

use App\Entity\StatsSet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method StatsSet|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatsSet|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatsSet[]    findAll()
 * @method StatsSet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatsSetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatsSet::class);
    }

    // /**
    //  * @return StatsSet[] Returns an array of StatsSet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StatsSet
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
