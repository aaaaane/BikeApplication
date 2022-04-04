<?php

namespace Vanmoof\Adapters\Repositories;

use BikeRepository;
use Doctrine\DBAL\Connection;
use SorryBikeNotFound;
use UserId;
use Vanmoof\Application\Domain\Bike;
use Vanmoof\Application\Domain\BikeId;

class DoctrineBikeRepository implements BikeRepository
{

    public function __construct(private Connection $connection)
    {
    }

    public function save(Bike $bike): void
    {
        // TODO: Implement save() method.
    }

    public function retrieve(BikeId $bikeId, UserId $userId): Bike
    {
        // TODO: Implement retrieve() method.
    }
}
