<?php

declare(strict_types=1);

namespace Vanmoof\Application\Ports;

use Vanmoof\Application\Domain\SorryBikeNotFound;
use Vanmoof\Application\Dto\BikeDtoRequest;
use Vanmoof\Application\Dto\BikeDtoResponse;

interface UpdateBikeInformationForUserPort
{
    /**
     * @throws SorryBikeNotFound
     */
    public function update(BikeDtoRequest $bikeDtoRequest): BikeDtoResponse;
}
