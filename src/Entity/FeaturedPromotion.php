<?php

namespace App\Entity;

use App\Repository\FeaturedPromotionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FeaturedPromotionRepository::class)
 */
class FeaturedPromotion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Promotion::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $promotion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }

    public function setPromotion(Promotion $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }
}
