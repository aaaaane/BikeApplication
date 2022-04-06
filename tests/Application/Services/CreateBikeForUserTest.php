<?php
declare(strict_types=1);

namespace Tests\Application\Services;

use Ramsey\Uuid\Rfc4122\UuidV4;
use Ramsey\Uuid\Uuid;
use Tests\Application\Domain\BikeStub;
use Vanmoof\Application\Domain\Bike;
use Vanmoof\Application\Domain\BikeId;
use Vanmoof\Application\Domain\BikeState;
use Vanmoof\Application\Domain\UserId;
use Vanmoof\Application\Dto\BikeDtoRequest;
use Vanmoof\Application\Services\ActivateBikeForUser;
use Vanmoof\Application\Services\ArchiveBikeForUser;
use PHPUnit\Framework\TestCase;
use Vanmoof\Application\Services\CreateBikeForUser;

class CreateBikeForUserTest extends TestCase
{
    use BikeStub;

    /** @test */
    public function it_should_create_a_bike()
    {
        // arrange
        $bikeRepository = new InMemoryBikeRepository();
        $bike = $this->createWithState(BikeState::INACTIVE);
        $createBike = new CreateBikeForUser($bikeRepository);
        $bikeDtoRequest = new BikeDtoRequest($bike->getUserId()->toString(),);

        $bikeDtoResponse = $createBike->create($bikeDtoRequest);

        // act
        $retrievedBike = $bikeRepository->retrieve(
            new BikeId(UuidV4::fromString($bikeDtoResponse->getBikeId())),
            new UserId(UuidV4::fromString($bikeDtoResponse->getUserId())),
        );

        // assert
        $this->assertInstanceOf(Bike::class, $retrievedBike);
    }
}
