<?php

namespace App\Repository;

use App\Entity\StatsSource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method StatsSource|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatsSource|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatsSource[]    findAll()
 * @method StatsSource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatsSourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatsSource::class);
    }

    public function findLastInserted(string $code)
    {
        return $this
            ->createQueryBuilder("e")
            ->where('e.code = :code')
            ->setParameter('code', $code)
            ->orderBy("id", "DESC")
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // /**
    //  * @return StatsSource[] Returns an array of StatsSource objects
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
    public function findOneBySomeField($value): ?StatsSource
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
