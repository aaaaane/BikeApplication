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

class ActivateBikeForUserTest extends TestCase
{
    use BikeStub;

    /** @test */
    public function it_should_activate_the_bike()
    {
        // arrange
        $bikeRepository = new InMemoryBikeRepository();
        $bike = $this->createWithState(BikeState::INACTIVE);
        $bikeRepository->save($bike);
        $activateBike = new ActivateBikeForUser($bikeRepository);
        $bikeDtoRequest = new BikeDtoRequest($bike->getUserId()->toString(),  $bike->getBikeId()->toString());

        // act
        $bikeDto = $activateBike->forUserId($bikeDtoRequest);
        $storedBike = $bikeRepository->retrieve($bike->getBikeId(), $bike->getUserId());

        // assert
        $this->assertEquals(BikeState::ACTIVE, $storedBike->getState());
        $this->assertEquals(BikeState::ACTIVE->value, $bikeDto->getState());
    }
}
