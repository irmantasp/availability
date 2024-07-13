<?php

namespace App\Entity;

use App\Entity\Trait\AuthorTrait;
use App\Entity\Trait\IdentifierTrait;
use App\Entity\Trait\TimestampedTrait;
use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
#[ORM\HasLifecycleCallbacks]
class Group implements IdentifierInterface, AuthorInterface, TimestampedEntityInterface
{
    use IdentifierTrait;
    use TimestampedTrait;
    use AuthorTrait;

    #[ORM\ManyToMany(targetEntity: User::class)]
    private Collection $members;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?bool $status = null;

    final public function __construct()
    {
        $this->members = new ArrayCollection();
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

    final public function getTitle(): ?string
    {
        return $this->title;
    }

    final public function setTitle(string $title): static
    {
        $this->title = $title;

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
