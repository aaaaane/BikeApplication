<?php
declare(strict_types=1);

namespace Tests\Application\Services;

use Ramsey\Uuid\Uuid;
use Tests\Application\Domain\BikeStub;
use Vanmoof\Application\Domain\BikeId;
use Vanmoof\Application\Domain\BikeState;
use Vanmoof\Application\Domain\SorryBikeNotFound;
use Vanmoof\Application\Domain\SorryCannotArchiveBikeBecauseStateIsNotInactive;
use Vanmoof\Application\Domain\UserId;
use Vanmoof\Application\Dto\BikeDtoRequest;
use Vanmoof\Application\Services\ArchiveBikeForUser;
use PHPUnit\Framework\TestCase;

class ArchiveBikeForUserTest extends TestCase
{
    use BikeStub;

    /** @test */
    public function it_should_archive_the_bike()
    {
        // arrange
        $bikeRepository = new InMemoryBikeRepository();
        $bike = $this->createWithState(BikeState::INACTIVE);
        $bikeRepository->save($bike);
        $archiveBike = new ArchiveBikeForUser($bikeRepository);
        $bikeDtoRequest = new BikeDtoRequest($bike->getUserId()->toString(),  $bike->getBikeId()->toString());

        // act
        $bikeDto = $archiveBike->archive($bikeDtoRequest);
        $storedBike = $bikeRepository->retrieve($bike->getBikeId(), $bike->getUserId());

        // assert
        $this->assertEquals(BikeState::ARCHIVED, $storedBike->getState());
        $this->assertEquals(BikeState::ARCHIVED->value, $bikeDto->getState());
    }

    /** @test */
    public function it_should_not_archive_the_bike()
    {
        // arrange
        $bikeRepository = new InMemoryBikeRepository();
        $bike = $this->createWithState(BikeState::ACTIVE);
        $bikeRepository->save($bike);
        $archiveBike = new ArchiveBikeForUser($bikeRepository);
        $bikeDtoRequest = new BikeDtoRequest($bike->getUserId()->toString(),  $bike->getBikeId()->toString());

        // we assert before acting because we expect an exception
        $this->expectException(SorryCannotArchiveBikeBecauseStateIsNotInactive::class);

        //act
        $archiveBike->archive($bikeDtoRequest);
    }
}
