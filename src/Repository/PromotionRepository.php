<?php

namespace App\Repository;

use App\Entity\Promotion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Promotion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Promotion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Promotion[]    findAll()
 * @method Promotion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromotionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Promotion::class);
    }

    public function getOffersFromPromotions(int $max)
    {
        return $this->createQueryBuilder('p')
            ->select('DISTINCT o.name')
            ->join('p.offerCombination', 'c', 'WITH', 'p.offerCombination = c.id')
            ->join('c.offer', 'o', 'WITH', 'c.offer = o.id')
            ->setMaxResults($max)
            ->getQuery()
            ->getArrayResult()
            ;
    }

    public function getOfferCombinationsFromPromotions($name)
    {
        return $this->createQueryBuilder('p')
            ->select('p.newPrice', 'c.price', 'c.type', 'n.name')
            ->join('p.offerCombination', 'c', 'WITH', 'p.offerCombination = c.id')
            ->join('c.offer', 'o', 'WITH', 'c.offer = o.id')
            ->join('o.category', 'n', 'WITH', 'o.category = n.id')
            ->where('o.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getArrayResult()
            ;
    }

    // /**
    //  * @return Promotion[] Returns an array of Promotion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Promotion
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
