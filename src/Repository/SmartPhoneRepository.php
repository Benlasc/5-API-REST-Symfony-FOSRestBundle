<?php

namespace App\Repository;

use App\Entity\SmartPhone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SmartPhone|null find($id, $lockMode = null, $lockVersion = null)
 * @method SmartPhone|null findOneBy(array $criteria, array $orderBy = null)
 * @method SmartPhone[]    findAll()
 * @method SmartPhone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SmartPhoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SmartPhone::class);
    }

    // /**
    //  * @return SmartPhone[] Returns an array of SmartPhone objects
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
    public function findOneBySomeField($value): ?SmartPhone
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
