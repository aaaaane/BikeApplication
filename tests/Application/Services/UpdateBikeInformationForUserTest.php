<?php
declare(strict_types=1);

namespace Tests\Application\Services;

use Ramsey\Uuid\Uuid;
use Tests\Application\Domain\BikeStub;
use Vanmoof\Application\Domain\BikeId;
use Vanmoof\Application\Domain\BikeState;
use Vanmoof\Application\Domain\UserId;
use Vanmoof\Application\Dto\BikeDtoRequest;
use Vanmoof\Application\Services\ActivateBikeForUser;
use Vanmoof\Application\Services\ArchiveBikeForUser;
use PHPUnit\Framework\TestCase;
use Vanmoof\Application\Services\UpdateBikeInformationForUser;

class UpdateBikeInformationForUserTest extends TestCase
{
    use BikeStub;

    /** @test */
    public function it_should_activate_the_bike()
    {
        // arrange
        $bikeRepository = new InMemoryBikeRepository();
        $bike = $this->createWithState(BikeState::INACTIVE);
        $bikeRepository->save($bike);
        $updateBike = new UpdateBikeInformationForUser($bikeRepository);

        $bikeDtoRequest = new BikeDtoRequest(
            $bike->getUserId()->toString(),
            $bike->getBikeId()->toString(),
            'Bike with another name',
            42,
        );

        // act
        $updateBike->forUserId($bikeDtoRequest);
        $storedBike = $bikeRepository->retrieve($bike->getBikeId(), $bike->getUserId());

        // assert
        $this->assertNotEquals($bike->getBikeInformation()->getName(), $storedBike->getBikeInformation()->getName());
        $this->assertNotEquals($bike->getBikeInformation()->getModel(), $storedBike->getBikeInformation()->getModel());
    }
}
