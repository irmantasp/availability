<?php

namespace App\Entity;

use App\Entity\Trait\AuthorTrait;
use App\Entity\Trait\IdentifierTrait;
use App\Entity\Trait\TimestampedTrait;
use App\Repository\AvailabilityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvailabilityRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Availability implements IdentifierInterface, AuthorInterface, TimestampedEntityInterface
{
    use IdentifierTrait;
    use TimestampedTrait;
    use AuthorTrait;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column]
    private ?int $month = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $days = [];

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
