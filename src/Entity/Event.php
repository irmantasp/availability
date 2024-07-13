<?php

namespace App\Entity;

use App\Entity\Trait\AuthorTrait;
use App\Entity\Trait\IdentifierTrait;
use App\Entity\Trait\TimestampedTrait;
use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Event implements IdentifierInterface, AuthorInterface, TimestampedEntityInterface
{
    use IdentifierTrait;
    use TimestampedTrait;
    use AuthorTrait;

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

    public function __toString(): string
    {
        return $this->getTitle();
    }
}
