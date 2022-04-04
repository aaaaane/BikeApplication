<?php

declare(strict_types=1);

use Vanmoof\Application\Domain\Bike;
use Vanmoof\Application\Domain\BikeId;

interface BikeRepository
{
    public function save(Bike $bike): void;

    /**
     * @throws SorryBikeNotFound
     */
    public function retrieve(BikeId $bikeId, UserId $userId): Bike;
}
