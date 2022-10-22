<?php

namespace App\Entity;

use App\Repository\LevelMapSizeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LevelMapSizeRepository::class)]
class LevelMapSize
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $huntTime = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Level $level = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?MapSize $mapSize = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHuntTime(): ?\DateTimeInterface
    {
        return $this->huntTime;
    }

    public function setHuntTime(\DateTimeInterface $huntTime): self
    {
        $this->huntTime = $huntTime;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(Level $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getMapSize(): ?MapSize
    {
        return $this->mapSize;
    }

    public function setMapSize(MapSize $mapSize): self
    {
        $this->mapSize = $mapSize;

        return $this;
    }
}
