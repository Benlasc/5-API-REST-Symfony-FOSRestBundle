<?php

namespace App\Repository;

use App\Entity\UserClient;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserClient[]    findAll()
 * @method UserClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserClientRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserClient::class);
    }

    public function search(int $userId, int $limit = 20, int $offset = 1)
    {
        $qb = $this->createQueryBuilder('u');

        $qb->where('u.user = :user_id')
           ->setParameter(':user_id', $userId);

        return $this->paginate($qb, $limit, $offset);
    }

    // /**
    //  * @return UserClient[] Returns an array of UserClient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserClient
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
