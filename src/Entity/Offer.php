<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfferRepository::class)
 */
class Offer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="offers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=2056, nullable=true)
     */
    private $describtion;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $aftercare;

    /**
     * @ORM\OneToMany(targetEntity=OfferCombination::class, mappedBy="offer", orphanRemoval=true)
     */
    private $offerCombinations;

    public function __construct()
    {
        $this->offerCombinations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDescribtion(): ?string
    {
        return $this->describtion;
    }

    public function setDescribtion(?string $describtion): self
    {
        $this->describtion = $describtion;

        return $this;
    }

    public function getAftercare(): ?string
    {
        return $this->aftercare;
    }

    public function setAftercare(?string $aftercare): self
    {
        $this->aftercare = $aftercare;

        return $this;
    }

    /**
     * @return Collection|OfferCombination[]
     */
    public function getOfferCombinations(): Collection
    {
        return $this->offerCombinations;
    }

    public function addOfferCombination(OfferCombination $offerCombination): self
    {
        if (!$this->offerCombinations->contains($offerCombination)) {
            $this->offerCombinations[] = $offerCombination;
            $offerCombination->setOffer($this);
        }

        return $this;
    }

    public function removeOfferCombination(OfferCombination $offerCombination): self
    {
        if ($this->offerCombinations->removeElement($offerCombination)) {
            // set the owning side to null (unless already changed)
            if ($offerCombination->getOffer() === $this) {
                $offerCombination->setOffer(null);
            }
        }

        return $this;
    }
}
