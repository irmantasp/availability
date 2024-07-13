<?php

namespace App\Entity\Trait;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

trait AuthorTrait
{
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    final public function getUser(): ?User
    {
        return $this->user;
    }

    final public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}