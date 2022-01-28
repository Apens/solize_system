<?php

namespace App\Repository;

use App\Entity\ServiceJob;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ServiceJob|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceJob|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceJob[]    findAll()
 * @method ServiceJob[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceJobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceJob::class);
    }

    // /**
    //  * @return ServiceJob[] Returns an array of ServiceJob objects
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
    public function findOneBySomeField($value): ?ServiceJob
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
