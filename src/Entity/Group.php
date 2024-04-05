<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
#[ORM\HasLifecycleCallbacks]
class Group implements AuthorInterface, TimestampedEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $members;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => 0])]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => 0])]
    private ?\DateTimeInterface $updated = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?bool $status = null;

    final public function __construct()
    {
        $this->members = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, User>
     */
    final public function getMembers(): Collection
    {
        return $this->members;
    }

    final public function addMember(User $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
        }

        return $this;
    }

    final public function removeMember(User $member): static
    {
        $this->members->removeElement($member);

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }
}
