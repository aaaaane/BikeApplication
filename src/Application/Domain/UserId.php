<?php

declare(strict_types=1);

namespace Vanmoof\Application\Domain;

use Ramsey\Uuid\UuidInterface;

class UserId
{
    public function __construct(private UuidInterface $userId)
    {
    }

    public function toString(): string
    {
        return $this->userId->toString();
    }
}
