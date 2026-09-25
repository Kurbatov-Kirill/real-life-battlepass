<?php

namespace App\Entity;

use App\Repository\QuestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Quest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'quests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Battlepass $battlepass = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $creator = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $target = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $helpersUrl = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reward = null;

    #[ORM\Column]
    private ?bool $isRewardHidden = false;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt;

    #[ORM\Column]
    private ?\DateTimeImmutable $deadlineAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $completedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $approvedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, QuestHistory>
     */
    #[ORM\OneToMany(targetEntity: QuestHistory::class, mappedBy: 'quest', orphanRemoval: true)]
    private Collection $questHistories;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->questHistories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBattlepass(): ?Battlepass
    {
        return $this->battlepass;
    }

    public function setBattlepass(?Battlepass $battlepass): static
    {
        $this->battlepass = $battlepass;

        return $this;
    }

    public function getCreator(): ?Profile
    {
        return $this->creator;
    }

    public function setCreator(?Profile $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    public function getTarget(): ?Profile
    {
        return $this->target;
    }

    public function setTarget(?Profile $target): static
    {
        $this->target = $target;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getHelpersUrl(): ?string
    {
        return $this->helpersUrl;
    }

    public function setHelpersUrl(?string $helpersUrl): static
    {
        $this->helpersUrl = $helpersUrl;

        return $this;
    }

    public function getReward(): ?string
    {
        return $this->reward;
    }

    public function setReward(?string $reward): static
    {
        $this->reward = $reward;

        return $this;
    }

    public function isRewardHidden(): ?bool
    {
        return $this->isRewardHidden;
    }

    public function setIsRewardHidden(bool $isRewardHidden): static
    {
        $this->isRewardHidden = $isRewardHidden;

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

    public function getDeadlineAt(): ?\DateTimeImmutable
    {
        return $this->deadlineAt;
    }

    public function setDeadlineAt(\DateTimeImmutable $deadlineAt): static
    {
        $this->deadlineAt = $deadlineAt;

        return $this;
    }

    public function getCompletedAt(): ?\DateTimeImmutable
    {
        return $this->completedAt;
    }

    public function setCompletedAt(?\DateTimeImmutable $completedAt): static
    {
        $this->completedAt = $completedAt;

        return $this;
    }

    public function getApprovedAt(): ?\DateTimeImmutable
    {
        return $this->approvedAt;
    }

    public function setApprovedAt(?\DateTimeImmutable $approvedAt): static
    {
        $this->approvedAt = $approvedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, QuestHistory>
     */
    public function getQuestHistories(): Collection
    {
        return $this->questHistories;
    }

    public function addQuestHistory(QuestHistory $questHistory): static
    {
        if (!$this->questHistories->contains($questHistory)) {
            $this->questHistories->add($questHistory);
            $questHistory->setQuest($this);
        }

        return $this;
    }

    public function removeQuestHistory(QuestHistory $questHistory): static
    {
        if ($this->questHistories->removeElement($questHistory)) {
            // set the owning side to null (unless already changed)
            if ($questHistory->getQuest() === $this) {
                $questHistory->setQuest(null);
            }
        }

        return $this;
    }

    #[ORM\PreUpdate]
    public function updateTimestamp(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
