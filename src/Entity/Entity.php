<?php

namespace App\Entity;

use App\Repository\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntityRepository::class)]
class Entity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $specialMove = null;

    #[ORM\ManyToMany(targetEntity: Evidence::class, inversedBy: 'entities')]
    private Collection $evidences;

    #[ORM\ManyToMany(targetEntity: Characteristic::class, mappedBy: 'entities')]
    private Collection $characteristics;

    public function __construct()
    {
        $this->evidences = new ArrayCollection();
        $this->characteristics = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSpecialMove(): ?string
    {
        return $this->specialMove;
    }

    public function setSpecialMove(string $specialMove): self
    {
        $this->specialMove = $specialMove;

        return $this;
    }

    /**
     * @return Collection<int, Evidence>
     */
    public function getEvidences(): Collection
    {
        return $this->evidences;
    }

    public function addEvidence(Evidence $evidence): self
    {
        if (!$this->evidences->contains($evidence)) {
            $this->evidences->add($evidence);
        }

        return $this;
    }

    public function removeEvidence(Evidence $evidence): self
    {
        $this->evidences->removeElement($evidence);

        return $this;
    }

    /**
     * @return Collection<int, Characteristic>
     */
    public function getCharacteristics(): Collection
    {
        return $this->characteristics;
    }

    public function addCharacteristic(Characteristic $characteristic): self
    {
        if (!$this->characteristics->contains($characteristic)) {
            $this->characteristics->add($characteristic);
            $characteristic->addEntity($this);
        }

        return $this;
    }

    public function removeCharacteristic(Characteristic $characteristic): self
    {
        if ($this->characteristics->removeElement($characteristic)) {
            $characteristic->removeEntity($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
