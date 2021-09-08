<?php
/**
 * Created by PhpStorm.
 * Project: centrumodnowybiologicznej
 * User: Patryk Szczepański
 * Date: 09/09/2021
 * Time: 00:53
 */

namespace App\Twig;

use App\Entity\Category;
use App\Entity\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class landingPageExtension extends AbstractExtension
{
    /**
     * @var EntityRepository
     */
    private $entityManager;

    /**
     * TemporaryEmailRepository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('getRandomOffer', [$this, 'getRandomOffer']),
        ];
    }

    public function getRandomOffer($categoryId)
    {
        $category = $this->entityManager->getRepository(Category::class)->find($categoryId);
        if(!$category)
            return "#";

        $offers = $this->entityManager->getRepository(Offer::class)->findBy(['category' => $category]);
        if(count($offers) == 0)
            return "#";

        $offer = $offers[array_rand($offers, 1)];

        return $offer->getName();
    }
}
