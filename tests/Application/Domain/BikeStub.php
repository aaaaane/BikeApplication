<?php

namespace Tests\Application\Domain;

use Ramsey\Uuid\Uuid;
use Vanmoof\Application\Domain\Bike;
use Vanmoof\Application\Domain\BikeId;
use Vanmoof\Application\Domain\BikeInformation;
use Vanmoof\Application\Domain\BikeState;
use Vanmoof\Application\Domain\UserId;

trait BikeStub
{
    public function createWithState(BikeState $bikeState): Bike
    {
        return new Bike(
            new BikeId(Uuid::uuid4()),
            new UserId(Uuid::uuid4()),
            new BikeInformation('Bici', 1),
            $bikeState,
        );
    }

    public function createWithUserId(UserId $userId): Bike
    {
        return new Bike(
            new BikeId(Uuid::uuid4()),
            $userId,
            new BikeInformation('Bici', 1),
            BikeState::INACTIVE,
        );
    }
}
