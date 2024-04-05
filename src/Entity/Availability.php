<?php

namespace App\Entity;

use App\Repository\AvailabilityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvailabilityRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Availability implements AuthorInterface, TimestampedEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column]
    private ?int $month = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $days = [];

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => 0])]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => 0])]
    private ?\DateTimeInterface $updated = null;

    final public function getId(): ?int
    {
        return $this->id;
    }

    final public function getYear(): ?int
    {
        return $this->year;
    }

    final public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    final public function getMonth(): ?int
    {
        return $this->month;
    }

    final public function setMonth(int $month): static
    {
        $this->month = $month;

        return $this;
    }

    final public function getDays(): array
    {
        return $this->days;
    }

    final public function setDays(array $days): static
    {
        $this->days = $days;

        return $this;
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

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    final public function sortDays(): void
    {
        $days = $this->days;
        $days = array_unique($days);
        sort($days);
        $this->days = $days;
    }
}
