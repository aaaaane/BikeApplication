<?php

declare(strict_types=1);

namespace Vanmoof\Application\Ports;

use Vanmoof\Application\Domain\SorryBikeNotFound;
use Vanmoof\Application\Domain\SorryCannotActivateBikeBecauseBikeStateIsActive;
use Vanmoof\Application\Dto\BikeDtoRequest;
use Vanmoof\Application\Dto\BikeDtoResponse;

interface ActivateBikeForUserPort
{
    /**
     * @throws SorryCannotActivateBikeBecauseBikeStateIsActive
     * @throws SorryBikeNotFound
     */
    public function forUserId(BikeDtoRequest $bikeDtoRequest): BikeDtoResponse;
}
