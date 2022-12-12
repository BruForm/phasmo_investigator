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

    #[ORM\OneToMany(mappedBy: 'entity', targetEntity: Game::class)]
    private Collection $games;

    #[ORM\OneToMany(mappedBy: 'chosenEntity', targetEntity: Game::class)]
    private Collection $gamesChosenEntity;

    public function __construct()
    {
        $this->evidences = new ArrayCollection();
        $this->characteristics = new ArrayCollection();
        $this->games = new ArrayCollection();
        $this->gamesChosenEntity = new ArrayCollection();
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
            $game->setEntity($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getEntity() === $this) {
                $game->setEntity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getgamesChosenEntity(): Collection
    {
        return $this->gamesChosenEntity;
    }

    public function addGameChosenEntity(Game $game): self
    {
        if (!$this->gamesChosenEntity->contains($game)) {
            $this->gamesChosenEntity->add($game);
            $game->setChosenEntity($this);
        }

        return $this;
    }

    public function removeGameChosenEntity(Game $game): self
    {
        if ($this->gamesChosenEntity->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getChosenEntity() === $this) {
                $game->setChosenEntity(null);
            }
        }

        return $this;
    }
}
