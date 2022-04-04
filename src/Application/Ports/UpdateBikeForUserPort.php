<?php

declare(strict_types=1);

use Vanmoof\Application\Domain\Bike;
use Vanmoof\Application\Domain\BikeId;

interface UpdateBikeForUserPort
{
    /**
     * @throws SorryBikeNotFound
     */
    public function forUserId(UserId $userId, BikeId $bikeId): Bike;
}
