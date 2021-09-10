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

    public function getOffersFromFeaturedPromotions(int $max)
    {
        return $this->createQueryBuilder('f')
            ->select('DISTINCT o.name')
            ->join('f.promotion', 'p', 'WITH', 'f.promotion = p.id')
            ->join('p.offerCombination', 'c', 'WITH', 'p.offerCombination = c.id')
            ->join('c.offer', 'o', 'WITH', 'c.offer = o.id')
            ->setMaxResults($max)
            ->getQuery()
            ->getArrayResult()
            ;
    }

    public function getOfferCombinationsFromFeaturedPromotions($name)
    {
        return $this->createQueryBuilder('f')
            ->select('p.newPrice', 'c.price', 'c.type', 'n.name')
            ->join('f.promotion', 'p', 'WITH', 'f.promotion = p.id')
            ->join('p.offerCombination', 'c', 'WITH', 'p.offerCombination = c.id')
            ->join('c.offer', 'o', 'WITH', 'c.offer = o.id')
            ->join('o.category', 'n', 'WITH', 'o.category = n.id')
            ->where('o.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getArrayResult()
        ;
    }

    /*
     * Data we need
     * Offers from featured promotions which have promotions
     * Offers combinations from promotions
     * group by offer
     */
}
