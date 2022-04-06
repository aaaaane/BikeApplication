<?php

declare(strict_types=1);

namespace Vanmoof\Application\Dto;

class BikeDtoRequest
{
    public function __construct(
        private readonly string $userId,
        private readonly ?string $bikeId = null,
        private readonly ?string $name = null,
        private readonly ?int $model = null,
        private readonly ?string $state = null,
    )
    {
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getModel(): int
    {
        return $this->model;
    }

    public function getBikeId(): ?string
    {
        return $this->bikeId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
