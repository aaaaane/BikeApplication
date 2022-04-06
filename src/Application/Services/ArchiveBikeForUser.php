<?php

declare(strict_types=1);

namespace Vanmoof\Application\Services;

use Ramsey\Uuid\Rfc4122\UuidV4;
use Vanmoof\Application\Domain\BikeId;
use Vanmoof\Application\Domain\SorryBikeNotFound;
use Vanmoof\Application\Domain\SorryCannotArchiveBikeBecauseStateIsNotInactive;
use Vanmoof\Application\Domain\UserId;
use Vanmoof\Application\Dto\BikeDtoRequest;
use Vanmoof\Application\Ports\ArchiveBikeForUserPort;
use Vanmoof\Application\Ports\BikeRepository;
use Vanmoof\Application\Dto\BikeDtoResponse;
use Webmozart\Assert\Assert;

class ArchiveBikeForUser implements ArchiveBikeForUserPort
{
    public function __construct(private BikeRepository $bikeRepository)
    {
    }

    /**
     * @throws SorryCannotArchiveBikeBecauseStateIsNotInactive
     * @throws SorryBikeNotFound
     */
    public function archive(BikeDtoRequest $bikeDtoRequest): BikeDtoResponse
    {
        $bike = $this->bikeRepository->retrieve(
            new BikeId(UuidV4::fromString($bikeDtoRequest->getBikeId())),
            new UserId(UuidV4::fromString($bikeDtoRequest->getUserId())),
        );

        $bike->archive();
        $this->bikeRepository->save($bike);

        return BikeDtoResponse::fromBike($bike);
    }
}
