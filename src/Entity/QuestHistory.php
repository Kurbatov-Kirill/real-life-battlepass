<?php

namespace App\Entity;

use App\Repository\QuestHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\QuestHistoryType;

#[ORM\Entity(repositoryClass: QuestHistoryRepository::class)]
class QuestHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'questHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quest $quest = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Profile $actor = null;

    #[ORM\Column(length: 32, enumType: QuestHistoryType::class)]
    private QuestHistoryType $type = QuestHistoryType::TEXT;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $message = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $proofUrl = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuest(): ?Quest
    {
        return $this->quest;
    }

    public function setQuest(?Quest $quest): static
    {
        $this->quest = $quest;

        return $this;
    }

    public function getActor(): ?Profile
    {
        return $this->actor;
    }

    public function setActor(?Profile $actor): static
    {
        $this->actor = $actor;

        return $this;
    }

    public function getType(): QuestHistoryType
    {
        return $this->type;
    }

    public function setType(QuestHistoryType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getProofUrl(): ?string
    {
        return $this->proofUrl;
    }

    public function setProofUrl(?string $proofUrl): static
    {
        $this->proofUrl = $proofUrl;

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
}
