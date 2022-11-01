<?php

namespace App\Entity;

use App\Repository\MapSizeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MapSizeRepository::class)]
class MapSize
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $nbMaxLightsOn = null;

    #[ORM\OneToMany(mappedBy: 'mapSize', targetEntity: ParamLevelMapSize::class)]
    private Collection $paramLevelMapSizes;

    public function __construct()
    {
        $this->paramLevelMapSizes = new ArrayCollection();
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

    public function getNbMaxLightsOn(): ?int
    {
        return $this->nbMaxLightsOn;
    }

    public function setNbMaxLightsOn(int $nbMaxLightsOn): self
    {
        $this->nbMaxLightsOn = $nbMaxLightsOn;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection<int, ParamLevelMapSize>
     */
    public function getParamLevelMapSizes(): Collection
    {
        return $this->paramLevelMapSizes;
    }

    public function addParamLevelMapSize(ParamLevelMapSize $paramLevelMapSize): self
    {
        if (!$this->paramLevelMapSizes->contains($paramLevelMapSize)) {
            $this->paramLevelMapSizes->add($paramLevelMapSize);
            $paramLevelMapSize->setMapSize($this);
        }

        return $this;
    }

    public function removeParamLevelMapSize(ParamLevelMapSize $paramLevelMapSize): self
    {
        if ($this->paramLevelMapSizes->removeElement($paramLevelMapSize)) {
            // set the owning side to null (unless already changed)
            if ($paramLevelMapSize->getMapSize() === $this) {
                $paramLevelMapSize->setMapSize(null);
            }
        }

        return $this;
    }
}
