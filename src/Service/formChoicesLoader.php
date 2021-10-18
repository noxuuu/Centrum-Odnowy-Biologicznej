<?php
/**
 * Created by PhpStorm.
 * Project: centrumodnowybiologicznej
 * User: Patryk Szczepański
 * Date: 10/09/2021
 * Time: 13:02
 */

namespace App\Service;


use App\Entity\OfferCombination;
use Doctrine\ORM\EntityManagerInterface;

class formChoicesLoader
{
    private $offerCombinationsRepo;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->offerCombinationsRepo = $entityManager->getRepository(OfferCombination::class);
    }

    public function loadPromotionsChoices() {
        $offerCombinations = $this->offerCombinationsRepo->findAll();

        $choiceList = array();
        foreach ($offerCombinations as $combination) {
            $type = $this->getTypeString($combination->getType());
            $price = $combination->getPrice() == 0 ? 'Indywidualnie':$combination->getPrice().' zł';

            $name = $combination->getOffer()->getName().' - '.$type.' - '.$price;

            $choiceList[$name] = $combination;
        }

        return $choiceList;
    }

    public function getTypeString($type) {
        switch($type) {
            case 1: return 'Twarz';
            case 2: return 'Twarz + Oczy';
            case 3: return 'Twarz + Szyja';
            case 4: return 'Twarz + Szyja + Dekolt';
            case 5: return 'Szyja';
            case 6: return 'Oczy';
            case 7: return 'Nos';
            case 8: return 'Dłonie';
            case 9: return 'Ciało';
        }
        return '';
    }
}
