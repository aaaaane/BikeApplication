<?php

declare(strict_types=1);

namespace Vanmoof\Application\Domain;

use http\Env\Request;

class Bike
{
    public function __construct(private BikeId $bikeId, private UserId $userId, private BikeInformation $bikeInformation, private BikeState $bikeState,)
    {
    }

    public static function withInactiveState(BikeId $bikeId, UserId $userId, BikeInformation $bikeInformation): self
    {
        return new self($bikeId , $userId, $bikeInformation, BikeState::INACTIVE);
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getState(): BikeState
    {
        return $this->bikeState;
    }

    public function getBikeId(): BikeId
    {
        return $this->bikeId;
    }

    public function getBikeInformation(): BikeInformation
    {
        return $this->bikeInformation;
    }

    public function activate(): void
    {
        $this->bikeState = BikeState::ACTIVE;
    }

    public function deactivate(): void
    {
        $this->bikeState = BikeState::INACTIVE;
    }

    /**
     * @throws SorryCannotArchiveBikeBecauseStateIsNotInactive
     * @NOTE: this is an invariant
     */
    public function archive(): void
    {
        if ($this->guardStateIsInactive() === false) {
            throw new SorryCannotArchiveBikeBecauseStateIsNotInactive(sprintf('With id %s', $this->bikeId->toString()));
        }

        $this->bikeState = BikeState::ARCHIVED;
    }

    private function guardStateIsInactive(): bool
    {
        return $this->bikeState === BikeState::INACTIVE;
    }
}
