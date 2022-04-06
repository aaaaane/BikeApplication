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
use Vanmoof\Application\Ports\ActivateBikeForUserPort;
use Vanmoof\Application\Ports\BikeRepository;
use Vanmoof\Application\Ports\GetAllBikesForUserPort;

class GetAllBikesForUser implements GetAllBikesForUserPort
{
    public function __construct(private BikeRepository $bikeRepository)
    {
    }

    /**
     * @return BikeDtoResponse[]
     */
    public function forUserId(BikeDtoRequest $bikeDtoRequest): array
    {
        $arrayOfBikes = $this->bikeRepository->retrieveAll(new UserId(UuidV4::fromString($bikeDtoRequest->getUserId())));

        $arrayOfBikeDtoResponse = [];

        foreach ($arrayOfBikes as $bike) {
            $arrayOfBikeDtoResponse[] = BikeDtoResponse::fromBike($bike);
        }

        return $arrayOfBikeDtoResponse;
    }
}
