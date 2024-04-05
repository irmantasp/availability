<?php

namespace App\Entity;

interface AuthorInterface
{
    public function getUser(): ?User;

    public function setUser(?User $user): static;
}