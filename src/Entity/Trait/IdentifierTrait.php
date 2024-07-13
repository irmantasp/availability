<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait IdentifierTrait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    final public function getId(): ?int
    {
        return $this->id;
    }
}