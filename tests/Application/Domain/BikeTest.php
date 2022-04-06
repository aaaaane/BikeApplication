<?php

declare(strict_types=1);

namespace Tests\Application\Domain;

use Ramsey\Uuid\Uuid;
use Vanmoof\Application\Domain\Bike;
use PHPUnit\Framework\TestCase;
use Vanmoof\Application\Domain\BikeId;
use Vanmoof\Application\Domain\BikeInformation;
use Vanmoof\Application\Domain\BikeState;
use Vanmoof\Application\Domain\SorryCannotArchiveBikeBecauseStateIsNotInactive;
use Vanmoof\Application\Domain\UserId;

class BikeTest extends TestCase
{
    use BikeStub;

    /** @test */
    public function it_should_archive_the_bike_when_state_is_inactive()
    {
        $bike = Bike::withInactiveState(new BikeId(Uuid::uuid4()), new UserId(Uuid::uuid4()), new BikeInformation('Bici', 1));
        $bike->archive();
        $this->assertEquals(BikeState::ARCHIVED, $bike->getState());
    }

    /** @test */
    public function it_should_not_archive_the_bike_when_state_is_active()
    {
        $bike = $this->createWithState(BikeState::ACTIVE);
        $this->expectException(SorryCannotArchiveBikeBecauseStateIsNotInactive::class);
        $bike->archive();
    }

    /** @test */
    public function it_changes_state_from_active_to_inactive()
    {
        $bike = new Bike(new BikeId(Uuid::uuid4()), new UserId(Uuid::uuid4()), new BikeInformation('Bici', 1), BikeState::ACTIVE);
        $bike->deactivate();
        $this->assertEquals(BikeState::INACTIVE, $bike->getState());
    }

    /** @test */
    public function it_changes_state_from_inactive_to_active()
    {
        $bike = new Bike(new BikeId(Uuid::uuid4()), new UserId(Uuid::uuid4()), new BikeInformation('Bici', 1), BikeState::INACTIVE);
        $bike->activate();
        $this->assertEquals(BikeState::ACTIVE, $bike->getState());
    }
}
