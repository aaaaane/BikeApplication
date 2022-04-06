<?php

declare(strict_types=1);

namespace Vanmoof\Application\Ports;

use Vanmoof\Application\Domain\SorryBikeNotFound;
use Vanmoof\Application\Domain\SorryCannotArchiveBikeBecauseStateIsNotInactive;
use Vanmoof\Application\Dto\BikeDtoRequest;
use Vanmoof\Application\Dto\BikeDtoResponse;

interface ArchiveBikeForUserPort
{
    /**
     * @throws SorryCannotArchiveBikeBecauseStateIsNotInactive
     * @throws SorryBikeNotFound
     */
    public function archive(BikeDtoRequest $bikeDtoRequest): BikeDtoResponse;
}
