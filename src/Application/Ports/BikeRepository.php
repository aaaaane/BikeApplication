<?php

declare(strict_types=1);

namespace Vanmoof\Application\Ports;

use Vanmoof\Application\Domain\Bike;
use Vanmoof\Application\Domain\BikeId;
use Vanmoof\Application\Domain\SorryBikeNotFound;
use Vanmoof\Application\Domain\UserId;

interface BikeRepository
{
    public function save(Bike $bike): void;

    /**
     * @throws SorryBikeNotFound
     */
    public function retrieve(BikeId $bikeId, UserId $userId): Bike;

    /**
     * @throws SorryBikeNotFound
     */
    public function delete(Bike $bike): void;

    /**
     * @return Bike[]
     */
    public function retrieveAll(UserId $userId): array;

}
