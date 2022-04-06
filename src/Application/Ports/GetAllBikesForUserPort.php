<?php

declare(strict_types=1);

namespace Vanmoof\Application\Ports;

use Vanmoof\Application\Domain\SorryBikeNotFound;
use Vanmoof\Application\Dto\BikeDtoRequest;
use Vanmoof\Application\Dto\BikeDtoResponse;

interface GetAllBikesForUserPort
{
    /**
     * @return BikeDtoResponse[]
     * @throws SorryBikeNotFound
     */
    public function getAll(BikeDtoRequest $bikeDtoRequest): array;
}
