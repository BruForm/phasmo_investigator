<?php

namespace App\Entity;

use App\Repository\LevelRepository;
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
}
