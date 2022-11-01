<?php

namespace App\Entity;

use App\Repository\MapRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MapRepository::class)]
class Map
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $nbFloor = null;

    #[ORM\Column]
    private ?int $nbRoom = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?MapSize $mapSize = null;

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

    public function getNbFloor(): ?int
    {
        return $this->nbFloor;
    }

    public function setNbFloor(int $nbFloor): self
    {
        $this->nbFloor = $nbFloor;

        return $this;
    }

    public function getNbRoom(): ?int
    {
        return $this->nbRoom;
    }

    public function setNbRoom(int $nbRoom): self
    {
        $this->nbRoom = $nbRoom;

        return $this;
    }

    public function getMapSize(): ?MapSize
    {
        return $this->mapSize;
    }

    public function setMapSize(?MapSize $mapSize): self
    {
        $this->mapSize = $mapSize;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
