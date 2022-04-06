<?php

namespace Tests\Application\Services;

use PHPUnit\Framework\TestCase;
use Tests\Application\Domain\BikeStub;
use Vanmoof\Application\Domain\BikeState;

class InMemoryBikeRepositoryTest extends TestCase
{
    use BikeStub;

    /** @test */
    public function it_should_store_a_bike(): void
    {
        $repository = new InMemoryBikeRepository();
        $bike = $this->createWithState(BikeState::ACTIVE);
        $repository->save($bike);

        $storedBike = $repository->retrieve($bike->getBikeId(), $bike->getUserId());

        $this->assertEquals($bike, $storedBike);
    }
}
