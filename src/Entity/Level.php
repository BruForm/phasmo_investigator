<?php

namespace App\Entity;

use App\Repository\LevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LevelRepository::class)]
class Level
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $freeRunTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $huntGraceTime = null;

    #[ORM\Column]
    private ?int $sanityByPill = null;

    #[ORM\Column]
    private ?int $insurancePayment = null;

    #[ORM\OneToMany(mappedBy: 'level', targetEntity: ParamLevelMapSize::class)]
    private Collection $paramLevelMapSizes;

    #[ORM\OneToMany(mappedBy: 'level', targetEntity: Game::class)]
    private Collection $games;

    public function __construct()
    {
        $this->paramLevelMapSizes = new ArrayCollection();
        $this->games = new ArrayCollection();
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

    public function getFreeRunTime(): ?\DateTimeInterface
    {
        return $this->freeRunTime;
    }

    public function setFreeRunTime(\DateTimeInterface $freeRunTime): self
    {
        $this->freeRunTime = $freeRunTime;

        return $this;
    }

    public function getHuntGraceTime(): ?\DateTimeInterface
    {
        return $this->huntGraceTime;
    }

    public function setHuntGraceTime(\DateTimeInterface $huntGraceTime): self
    {
        $this->huntGraceTime = $huntGraceTime;

        return $this;
    }

    public function getSanityByPill(): ?int
    {
        return $this->sanityByPill;
    }

    public function setSanityByPill(int $sanityByPill): self
    {
        $this->sanityByPill = $sanityByPill;

        return $this;
    }

    public function getInsurancePayment(): ?int
    {
        return $this->insurancePayment;
    }

    public function setInsurancePayment(int $insurancePayment): self
    {
        $this->insurancePayment = $insurancePayment;

        return $this;
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
            $paramLevelMapSize->setLevel($this);
        }

        return $this;
    }

    public function removeParamLevelMapSize(ParamLevelMapSize $paramLevelMapSize): self
    {
        if ($this->paramLevelMapSizes->removeElement($paramLevelMapSize)) {
            // set the owning side to null (unless already changed)
            if ($paramLevelMapSize->getLevel() === $this) {
                $paramLevelMapSize->setLevel(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games->add($game);
            $game->setLevel($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getLevel() === $this) {
                $game->setLevel(null);
            }
        }

        return $this;
    }
}
