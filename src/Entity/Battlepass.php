<?php

namespace App\Entity;

use App\Repository\BattlepassRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BattlepassRepository::class)]
class Battlepass
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'player_1_id', nullable: false)]
    private ?Profile $player1 = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'player_2_id', nullable: false)]
    private ?Profile $player2 = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt;

    /**
     * @var Collection<int, Quest>
     */
    #[ORM\OneToMany(targetEntity: Quest::class, mappedBy: 'battlepass', orphanRemoval: true)]
    private Collection $quests;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->quests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPlayer1(): ?Profile
    {
        return $this->player1;
    }

    public function setPlayer1(?Profile $player1): static
    {
        $this->player1 = $player1;

        return $this;
    }

    public function getPlayer2(): ?Profile
    {
        return $this->player2;
    }

    public function setPlayer2(?Profile $player2): static
    {
        $this->player2 = $player2;

        return $this;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Quest>
     */
    public function getQuests(): Collection
    {
        return $this->quests;
    }

    public function addQuest(Quest $quest): static
    {
        if (!$this->quests->contains($quest)) {
            $this->quests->add($quest);
            $quest->setBattlepass($this);
        }

        return $this;
    }

    public function removeQuest(Quest $quest): static
    {
        if ($this->quests->removeElement($quest)) {
            // set the owning side to null (unless already changed)
            if ($quest->getBattlepass() === $this) {
                $quest->setBattlepass(null);
            }
        }

        return $this;
    }
}
