<?php

namespace App\Entity;

interface TimestampedEntityInterface
{
    public function setCreatedValue(): void;

    public function setUpdatedValue(): void;
}
