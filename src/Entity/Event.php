<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Event implements AuthorInterface, TimestampedEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Group $userGroup = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => 0])]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => 0])]
    private ?\DateTimeInterface $updated = null;

    final public function getId(): ?int
    {
        return $this->id;
    }

    final public function getUser(): ?User
    {
        return $this->user;
    }

    final public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    final public function getUserGroup(): ?Group
    {
        return $this->userGroup;
    }

    final public function setUserGroup(?Group $userGroup): static
    {
        $this->userGroup = $userGroup;

        return $this;
    }

    final public function getTitle(): ?string
    {
        return $this->title;
    }

    final public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    final public function getDescription(): ?string
    {
        return $this->description;
    }

    final public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    final public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    final public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    final public function isStatus(): ?bool
    {
        return $this->status;
    }

    final public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }


    final public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    final public function setCreated(\DateTimeInterface $created): static
    {
        $this->created = $created;

        return $this;
    }

    final public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    final public function setUpdated(\DateTimeInterface $updated): static
    {
        $this->updated = $updated;

        return $this;
    }

    #[ORM\PrePersist]
    final public function setCreatedValue(): void
    {
        $this->created = new \DateTime();
    }

    #[ORM\PreUpdate]
    final public function setUpdatedValue(): void
    {
        $this->updated = new \DateTime();
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }
}
