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
use function PHPUnit\Framework\throwException;

class ActivateBikeForUser implements ActivateBikeForUserPort
{
    public function __construct(private BikeRepository $bikeRepository)
    {
    }

    public function activate(BikeDtoRequest $bikeDtoRequest): BikeDtoResponse
    {
        $bike = $this->bikeRepository->retrieve(
            new BikeId(UuidV4::fromString($bikeDtoRequest->getBikeId())),
            new UserId(UuidV4::fromString($bikeDtoRequest->getUserId())),
        );

        $bike->activate();
        $this->bikeRepository->save($bike);

        return BikeDtoResponse::fromBike($bike);
    }
}
