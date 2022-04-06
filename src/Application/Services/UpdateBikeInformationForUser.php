<?php

declare(strict_types=1);

namespace Vanmoof\Application\Services;

use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\Uuid;
use Vanmoof\Application\Domain\Bike;
use Vanmoof\Application\Domain\BikeId;
use Vanmoof\Application\Domain\BikeInformation;
use Vanmoof\Application\Domain\BikeState;
use Vanmoof\Application\Domain\SorryBikeNotFound;
use Vanmoof\Application\Domain\UserId;
use Vanmoof\Application\Dto\BikeDtoRequest;
use Vanmoof\Application\Dto\BikeDtoResponse;
use Vanmoof\Application\Ports\BikeRepository;
use Vanmoof\Application\Ports\UpdateBikeInformationForUserPort;

class UpdateBikeInformationForUser implements UpdateBikeInformationForUserPort
{
    public function __construct(private BikeRepository $bikeRepository)
    {
    }

    public function forUserId(BikeDtoRequest $bikeDtoRequest): BikeDtoResponse
    {
        $bike = $this->bikeRepository->retrieve(
            new BikeId(UuidV4::fromString($bikeDtoRequest->getBikeId())),
            new UserId(UuidV4::fromString($bikeDtoRequest->getUserId())),
        );

        $bikeUpdated = new Bike(
            $bike->getBikeId(),
            $bike->getUserId(),
            new BikeInformation($bikeDtoRequest->getName(), $bikeDtoRequest->getModel()),
            BikeState::from($bike->getState()->value),
        );

        $this->bikeRepository->save($bikeUpdated);

        return BikeDtoResponse::fromBike($bikeUpdated);
    }
}
