<?php

declare(strict_types=1);

namespace Vanmoof\Application\Ports;

use Vanmoof\Application\Domain\Bike;
use Vanmoof\Application\Domain\SorryBikeNotFound;
use Vanmoof\Application\Dto\BikeDtoRequest;

interface DeleteBikeForUserPort
{
    /**
     * @throws SorryBikeNotFound
     */
    public function delete(BikeDtoRequest $bikeDtoRequest): void;

}
