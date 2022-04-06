<?php

declare(strict_types=1);

namespace Vanmoof\Application\Dto;

use Vanmoof\Application\Domain\Bike;

class BikeDtoResponse
{
    private function __construct(
        private readonly string $bikeId,
        private readonly string $userId,
        private readonly string $state,
        private readonly ?string $name = null,
        private readonly ?int $model = null,
    )
    {
    }

    public static function fromBike(Bike $bike): self
    {
        return new self(
            $bike->getBikeId()->toString(),
            $bike->getUserId()->toString(),
            $bike->getState()->value,
            $bike->getBikeInformation()->getName(),
            $bike->getBikeInformation()->getModel(),
        );
    }

    public function getName(): string
    {
        return $this->name;
    }
    
    public function getModel(): int
    {
        return $this->model;
    }

    public function getBikeId(): string
    {
        return $this->bikeId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function toArray(): array
    {
        return [
            'bikeId' => $this->bikeId,
            'userId' => $this->userId,
            'state' => $this->state,
            'name' => $this->name,
            'model' => $this->model,
        ];
    }
}
