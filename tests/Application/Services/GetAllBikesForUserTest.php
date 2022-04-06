<?php
declare(strict_types=1);

namespace Tests\Application\Services;

use PHPUnit\Framework\TestCase;
use Tests\Application\Domain\BikeStub;
use Vanmoof\Application\Domain\Bike;
use Vanmoof\Application\Domain\BikeState;

class GetAllBikesForUserTest extends TestCase
{
    use BikeStub;

    /** @test */
    public function it_should_retrieve_all_bikes_for_user()
    {
        // arrange
        $bikeRepository = new InMemoryBikeRepository();

        $bike1 = $this->createWithState(BikeState::INACTIVE);
        $bikeRepository->save($bike1);

        $bike2 = $this->createWithUserId($bike1->getUserId());
        $bikeRepository->save($bike2);


        $storedBikes = $bikeRepository->retrieveAll($bike1->getUserId());

        // assert
        $this->assertIsArray($storedBikes);

        foreach ($storedBikes as $bike) {
            $this->assertInstanceOf(Bike::class, $bike);
        }
    }
}
