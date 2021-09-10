<?php

namespace App\Repository;

use App\Entity\FeaturedPromotion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FeaturedPromotion|null find($id, $lockMode = null, $lockVersion = null)
 * @method FeaturedPromotion|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeaturedPromotion[]    findAll()
 * @method FeaturedPromotion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeaturedPromotionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FeaturedPromotion::class);
    }

    // /**
    //  * @return FeaturedPromotion[] Returns an array of FeaturedPromotion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FeaturedPromotion
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
