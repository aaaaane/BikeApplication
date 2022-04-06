<?php

namespace Vanmoof\Adapters\Repositories;

use Doctrine\DBAL\Connection;
use Ramsey\Uuid\Rfc4122\UuidV4;
use Vanmoof\Application\Domain\Bike;
use Vanmoof\Application\Domain\BikeId;
use Vanmoof\Application\Domain\BikeInformation;
use Vanmoof\Application\Domain\BikeState;
use Vanmoof\Application\Domain\SorryBikeNotFound;
use Vanmoof\Application\Domain\UserId;
use Vanmoof\Application\Ports\BikeRepository;

class DoctrineBikeRepository implements BikeRepository
{

    public function __construct(private Connection $connection)
    {
    }

    /**
     * @throws SorryBikeNotFound
     */
    public function save(Bike $bike): void
    {
        try {
            $this->retrieve($bike->getBikeId(), $bike->getUserId());
        } catch (SorryBikeNotFound) {
            $data = [
                'id' => $bike->getBikeId()->toString(),
                'user_id' => $bike->getUserId()->toString(),
                'state' => $bike->getstate()->value,
                'name' => $bike->getBikeInformation()->getName(),
                'model' => $bike->getBikeInformation()->getModel(),
            ];

            $this->connection->insert('Bike', $data);

            return;
        }

        $data = [
            'name' => $bike->getBikeInformation()->getName(),
            'model' => $bike->getBikeInformation()->getModel(),
            'state' => $bike->getState()->value,
        ];

        $criteria = [
            'id' => $bike->getBikeId()->toString(),
            'user_id' => $bike->getUserId()->toString(),
        ];

        $this->connection->update('Bike', $data, $criteria);
    }

    /**
     * @throws SorryBikeNotFound;
     */
    public function retrieve(BikeId $bikeId, UserId $userId): Bike
    {
        $result = $this->connection->executeQuery(
            'SELECT id, user_id, state, name, model FROM Bike WHERE id = :id AND user_id = :user_id', [
                'id' => $bikeId->toString(),
                'user_id' => $userId->toString(),
            ]
        );

        if ($result->rowCount() === 0) {
            throw new SorryBikeNotFound();
        }

        $bikeResult = $result->fetchAssociative();

        return $this->fetchBike($bikeResult);
    }

    /**
     * @throws SorryBikeNotFound;
     */
    public function delete(Bike $bike): void
    {
        try {
            $this->retrieve($bike->getBikeId(), $bike->getUserId());
        } catch (SorryBikeNotFound) {
            return;
        }

        $criteria = [
            'id' => $bike->getBikeId()->toString(),
            'user_id' => $bike->getUserId()->toString(),
        ];

        $this->connection->delete('Bike', $criteria);

    }

    /**
     * @return Bike[]
     * @throws SorryBikeNotFound
     */
    public function retrieveAll(UserId $userId): array
    {
        $result = $this->connection->executeQuery(
            'SELECT id, user_id, state, name, model FROM Bike WHERE user_id = :user_id', [
                'user_id' => $userId->toString(),
            ]
        );

        if ($result->rowCount() === 0) {
            throw new SorryBikeNotFound();
        }

        $arrayOfBikes = [];

        foreach ($result->fetchAllAssociative() as $bike) {
            $arrayOfBikes[] = $this->fetchBike($bike);
        }

        return $arrayOfBikes;
    }

    private function fetchBike(array $bikeArray): Bike
    {
        return new Bike(
            new BikeId(UuidV4::fromString($bikeArray['id'])),
            new UserId(UuidV4::fromString($bikeArray['user_id'])),
            new BikeInformation($bikeArray['name'], $bikeArray['model']),
            BikeState::from($bikeArray['state']),
        );
    }
}
