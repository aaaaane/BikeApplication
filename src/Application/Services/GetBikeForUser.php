<?php

declare(strict_types=1);

namespace Vanmoof\Application\Services;

use Ramsey\Uuid\Rfc4122\UuidV4;
use Vanmoof\Application\Domain\BikeId;
use Vanmoof\Application\Domain\UserId;
use Vanmoof\Application\Dto\BikeDtoRequest;
use Vanmoof\Application\Dto\BikeDtoResponse;
use Vanmoof\Application\Ports\BikeRepository;
use Vanmoof\Application\Ports\GetBikeForUserPort;

class GetBikeForUser implements GetBikeForUserPort
{
    public function __construct(private BikeRepository $bikeRepository)
    {
    }

    public function get(BikeDtoRequest $bikeDtoRequest): BikeDtoResponse
    {

        $bike = $this->bikeRepository->retrieve(
            new BikeId(UuidV4::fromString($bikeDtoRequest->getBikeId())),
            new UserId(UuidV4::fromString($bikeDtoRequest->getUserId())),
        );

        return BikeDtoResponse::fromBike($bike);
    }
}
