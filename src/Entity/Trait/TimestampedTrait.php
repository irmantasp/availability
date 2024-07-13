<?php

namespace App\Entity\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait TimestampedTrait
{
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => 0])]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['default' => 0])]
    private ?\DateTimeInterface $updated = null;

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
}
