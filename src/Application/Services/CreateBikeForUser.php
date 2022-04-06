<?php

declare(strict_types=1);

namespace Vanmoof\Application\Services;

use Ramsey\Uuid\Uuid;
use Vanmoof\Application\Domain\Bike;
use Vanmoof\Application\Domain\BikeId;
use Vanmoof\Application\Domain\BikeInformation;
use Vanmoof\Application\Domain\UserId;
use Vanmoof\Application\Dto\BikeDtoRequest;
use Vanmoof\Application\Dto\BikeDtoResponse;
use Vanmoof\Application\Ports\BikeRepository;
use Vanmoof\Application\Ports\CreateBikeForUserPort;

class CreateBikeForUser implements CreateBikeForUserPort
{
    public function __construct(private BikeRepository $bikeRepository)
    {
    }

    public function create(BikeDtoRequest $bikeDtoRequest): BikeDtoResponse
    {
        $bike = Bike::withInactiveState(
            new BikeId(Uuid::uuid4()),
            new UserId(Uuid::fromString($bikeDtoRequest->getUserId())),
            new BikeInformation('Standard Bike', 1)
        );

        $this->bikeRepository->save($bike);
        return BikeDtoResponse::fromBike($bike);
    }
}
