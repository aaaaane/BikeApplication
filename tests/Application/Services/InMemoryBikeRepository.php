<?php

namespace Tests\Application\Services;

use Vanmoof\Application\Domain\Bike;
use Vanmoof\Application\Domain\BikeId;
use Vanmoof\Application\Domain\SorryBikeNotFound;
use Vanmoof\Application\Domain\UserId;
use Vanmoof\Application\Ports\BikeRepository;

class InMemoryBikeRepository implements BikeRepository
{
    private array $container = [];

    public function save(Bike $bike): void
    {
        $this->container[$bike->getBikeId()->toString() . $bike->getUserId()->toString()] = $bike;
    }

    /**
     * @throws SorryBikeNotFound
     */
    public function retrieve(BikeId $bikeId, UserId $userId): Bike
    {
        if (array_key_exists($bikeId->toString() . $userId->toString(), $this->container)) {
            return $this->container[$bikeId->toString() . $userId->toString()];
        }

        throw new SorryBikeNotFound();
    }

    public function delete(Bike $bike): void
    {
        unset($this->container[$bike->getBikeId()->toString() . $bike->getUserId()->toString()]);
    }

    /**
     * @return Bike[]
     */
    public function retrieveAll(UserId $userId): array
    {
        return $this->container;
    }
}
