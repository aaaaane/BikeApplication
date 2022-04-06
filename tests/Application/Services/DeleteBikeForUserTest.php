<?php
declare(strict_types=1);

namespace Tests\Application\Services;

use Ramsey\Uuid\Uuid;
use Tests\Application\Domain\BikeStub;
use Vanmoof\Application\Domain\Bike;
use Vanmoof\Application\Domain\BikeId;
use Vanmoof\Application\Domain\BikeState;
use Vanmoof\Application\Domain\SorryBikeNotFound;
use Vanmoof\Application\Domain\UserId;
use Vanmoof\Application\Dto\BikeDtoRequest;
use Vanmoof\Application\Services\ActivateBikeForUser;
use Vanmoof\Application\Services\ArchiveBikeForUser;
use PHPUnit\Framework\TestCase;

class DeleteBikeForUserTest extends TestCase
{
    use BikeStub;

    /** @test */
    public function it_should_delete_a_bike()
    {
        // arrange
        $bikeRepository = new InMemoryBikeRepository();
        $bike = $this->createWithState(BikeState::INACTIVE);
        $bikeRepository->save($bike);

        $storedBike = $bikeRepository->retrieve($bike->getBikeId(), $bike->getUserId());
        $this->assertInstanceOf(Bike::class, $storedBike);
        $bikeRepository->delete($storedBike);

        $this->expectException(SorryBikeNotFound::class);

        $bikeRepository->retrieve($bike->getBikeId(), $bike->getUserId());
    }
}
