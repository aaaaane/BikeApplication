<?php

declare(strict_types=1);

namespace Vanmoof\Application\Domain;

use Ramsey\Uuid\UuidInterface;

class BikeId
{
    public function __construct(private UuidInterface $bikeId)
    {
    }

    public function toString(): string
    {
        return $this->bikeId->toString();
    }
}
