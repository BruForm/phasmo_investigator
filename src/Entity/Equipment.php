<?php

namespace App\Entity;

use App\Repository\EquipmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $utilisation = null;

    #[ORM\ManyToMany(targetEntity: Evidence::class, inversedBy: 'equipments')]
    private Collection $evidences;

    #[ORM\ManyToMany(targetEntity: OptionalGoal::class, mappedBy: 'equipments')]
    private Collection $optionalGoals;

    public function __construct()
    {
        $this->evidences = new ArrayCollection();
        $this->optionalGoals = new ArrayCollection();
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
     * @return Collection<int, OptionalGoal>
     */
    public function getOptionalGoals(): Collection
    {
        return $this->optionalGoals;
    }

    public function addOptionalGoal(OptionalGoal $optionalGoal): self
    {
        if (!$this->optionalGoals->contains($optionalGoal)) {
            $this->optionalGoals->add($optionalGoal);
            $optionalGoal->addEquipment($this);
        }

        return $this;
    }

    public function removeOptionalGoal(OptionalGoal $optionalGoal): self
    {
        if ($this->optionalGoals->removeElement($optionalGoal)) {
            $optionalGoal->removeEquipment($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
