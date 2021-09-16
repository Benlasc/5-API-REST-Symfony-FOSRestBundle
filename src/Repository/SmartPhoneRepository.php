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

    public function findBrand(?string $brand = null, string $price)
    {
        $qb = $this->createQueryBuilder('s')
                   ->orderBy('s.price', $price);

        if ($brand) {
            $qb->Where('s.brand =:brand')
                ->setParameter(':brand', $brand);
        }

        return $qb->getQuery()->getResult();
    }
}
