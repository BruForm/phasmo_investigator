<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipmentRepository::class)]
class Equipment
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
    private ?string $utilisation = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Evidence $evidence = null;

    #[ORM\ManyToMany(targetEntity: OptionalGoal::class, inversedBy: 'equipments')]
    private Collection $OptionalGoals;

    public function __construct()
    {
        $this->OptionalGoals = new ArrayCollection();
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

    public function getUtilisation(): ?string
    {
        return $this->utilisation;
    }

    public function setUtilisation(string $utilisation): self
    {
        $this->utilisation = $utilisation;

        return $this;
    }

    public function getEvidence(): ?Evidence
    {
        return $this->evidence;
    }

    public function setEvidence(?Evidence $evidence): self
    {
        $this->evidence = $evidence;

        return $this;
    }

    /**
     * @return Collection<int, OptionalGoal>
     */
    public function getOptionalGoals(): Collection
    {
        return $this->OptionalGoals;
    }

    public function addOptionalGoal(OptionalGoal $optionalGoal): self
    {
        if (!$this->OptionalGoals->contains($optionalGoal)) {
            $this->OptionalGoals->add($optionalGoal);
        }

        return $this;
    }

    public function removeOptionalGoal(OptionalGoal $optionalGoal): self
    {
        $this->OptionalGoals->removeElement($optionalGoal);

        return $this;
    }
}
