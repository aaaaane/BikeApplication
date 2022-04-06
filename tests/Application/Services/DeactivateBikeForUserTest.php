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
use Vanmoof\Application\Services\DeactivateBikeForUser;

class DeactivateBikeForUserTest extends TestCase
{
    use BikeStub;

    /** @test */
    public function it_should_deactivate_the_bike()
    {
        // arrange
        $bikeRepository = new InMemoryBikeRepository();
        $bike = $this->createWithState(BikeState::ACTIVE);
        $bikeRepository->save($bike);
        $deactivateBike = new DeactivateBikeForUser($bikeRepository);
        $bikeDtoRequest = new BikeDtoRequest($bike->getUserId()->toString(),  $bike->getBikeId()->toString());

        // act
        $bikeDto = $deactivateBike->forUserId($bikeDtoRequest);
        $storedBike = $bikeRepository->retrieve($bike->getBikeId(), $bike->getUserId());

        // assert
        $this->assertEquals(BikeState::INACTIVE, $storedBike->getState());
        $this->assertEquals(BikeState::INACTIVE->value, $bikeDto->getState());
    }
}
