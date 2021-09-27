<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PromotionRepository::class)
 */
class Promotion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=OfferCombination::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $offerCombination;

    /**
     * @ORM\Column(type="integer")
     */
    private $newPrice;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOfferCombination(): ?OfferCombination
    {
        return $this->offerCombination;
    }

    public function setOfferCombination(OfferCombination $offerCombination): self
    {
        $this->offerCombination = $offerCombination;

        return $this;
    }

    public function getNewPrice(): ?int
    {
        return $this->newPrice;
    }

    public function setNewPrice(int $newPrice): self
    {
        $this->newPrice = $newPrice;

        return $this;
    }
}
