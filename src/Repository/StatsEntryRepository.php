<?php

namespace App\Repository;

use App\Entity\StatsEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method StatsEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatsEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatsEntry[]    findAll()
 * @method StatsEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatsEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatsEntry::class);
    }

    // /**
    //  * @return StatsEntry[] Returns an array of StatsEntry objects
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
    public function findOneBySomeField($value): ?StatsEntry
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
