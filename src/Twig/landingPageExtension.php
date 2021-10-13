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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class landingPageExtension extends AbstractExtension
{
    /**
     * @var EntityRepository
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $router;

    /**
     * TemporaryEmailRepository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $router)
    {
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('getRandomOfferLink', [$this, 'getRandomOfferLink']),
            new TwigFilter('getCategoryOffers', [$this, 'getCategoryOffers']),
            new TwigFilter('processType', [$this, 'processType']),
            new TwigFilter('haveChild', [$this, 'haveChild']),
        ];
    }

    public function getRandomOfferLink($categoryId)
    {

        $category = $this->entityManager->getRepository(Category::class)->find($categoryId);
        if(!$category)
            return "#";

        $offers = $this->entityManager->getRepository(Offer::class)->findBy(['category' => $category]);
        if(count($offers) == 0) {
            // level is different than main, so we're checking for subcategories
            foreach ($category->getSubCategories() as $subcategory) {
                $subcategoryOffers = $this->entityManager->getRepository(Offer::class)->findBy(['category' => $subcategory]);
                if(count($subcategoryOffers) > 0) {
                    $offers = $subcategoryOffers;
                    break;
                }
            }

            // check wheter we found some offers or not
            if(count($offers) == 0)
                return "#";
        }

        $offer = $offers[array_rand($offers, 1)];

        return $this->router->generate('offerDetailsPage', ['category' => $category->getName(), 'offer' => $offer->getName()]);
    }


    public function getCategoryOffers($categoryId)
    {
        // find category
        $category = $this->entityManager->getRepository(Category::class)->find($categoryId);
        if(!$category)
            return [];

        return $this->entityManager->getRepository(Offer::class)->findBy(['category' => $category]);
    }

    public function processType($type)
    {
        switch($type) {
            case 0: return 'Zabieg';
            case 1: return 'Twarz';
            case 2: return 'Twarz + Oczy';
            case 3: return 'Twarz + Szyja';
            case 4: return 'Twarz + Szyja + Dekolt';
            case 5: return 'Szyja';
            case 6: return 'Oczy';
            case 7: return 'Dekolt';
            case 8: return 'Nos';
            case 9: return 'Dłonie';
            case 10: return 'Ciało';
            case 11: return 'Wąsik';
            case 12: return 'Broda';
            case 13: return 'Policzki';
            case 14: return 'Bikini';
            case 15: return 'Linia biała';
            case 16: return 'Obszar między pośladkami';
            case 17: return 'Pachy';
            case 18: return 'Plecy';
            case 19: return 'Nogi';
            case 20: return 'Łydki';
            case 21: return 'Uda';
            case 22: return 'Brzuch';
            case 23: return 'Stopy';
            case 24: return 'Pośladki';
            case 25: return 'Uda + Pośladki';
            case 26: return 'Ramiona';
        }
        return '';
    }

    public function haveChild($parent)
    {
        $categoryRepo = $this->entityManager->getRepository(Category::class);
        $categories = $categoryRepo->findBy(['parent' => $parent]);
        if(count($categories) > 0)
            return true;

        return false;
    }
}
