<?php

declare(strict_types=1);

namespace Vanmoof\Application\Services;

use Ramsey\Uuid\Rfc4122\UuidV4;
use Vanmoof\Application\Domain\Bike;
use Vanmoof\Application\Domain\BikeId;
use Vanmoof\Application\Domain\BikeInformation;
use Vanmoof\Application\Domain\BikeState;
use Vanmoof\Application\Domain\UserId;
use Vanmoof\Application\Dto\BikeDtoRequest;
use Vanmoof\Application\Ports\BikeRepository;
use Vanmoof\Application\Ports\DeleteBikeForUserPort;

class DeleteBikeForUser implements DeleteBikeForUserPort
{
    public function __construct(private BikeRepository $bikeRepository)
    {
    }

    public function delete(BikeDtoRequest $bikeDtoRequest): void
    {
        $bike = $this->bikeRepository->retrieve(
            new BikeId(UuidV4::fromString($bikeDtoRequest->getBikeId())),
            new UserId(UuidV4::fromString($bikeDtoRequest->getUserId())),
        );

        $bikeDeleted = new Bike(
            $bike->getBikeId(),
            $bike->getUserId(),
            $bike->getBikeInformation(),
            BikeState::from($bike->getState()->value),
        );

        $this->bikeRepository->delete($bikeDeleted);
    }
}
