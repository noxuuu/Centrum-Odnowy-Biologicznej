<?php

namespace App\Repository;

use App\Entity\OfferCombination;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OfferCombination|null find($id, $lockMode = null, $lockVersion = null)
 * @method OfferCombination|null findOneBy(array $criteria, array $orderBy = null)
 * @method OfferCombination[]    findAll()
 * @method OfferCombination[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferCombinationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OfferCombination::class);
    }

    // /**
    //  * @return OfferCombination[] Returns an array of OfferCombination objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OfferCombination
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
