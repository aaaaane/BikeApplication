<?php

declare(strict_types=1);

use Vanmoof\Application\Domain\Bike;
use Vanmoof\Application\Domain\BikeId;

class CreateBikeForUser implements CreateBikeForUserPort
{
    public function __construct(private BikeRepository $bikeRepository)
    {
    }

    public function forUserId(UserId $userId, BikeId $bikeId): Bike
    {
        $bike = $this->bikeRepository->retrieve($bikeId, $userId);


        // mirar si la bici existeix a la bbdd
        // mirar si l'usuari te permis per executar aixo
        // agafar la bici del port del repositori
        // mutar l'estat de la bici
        // guardar
        // retornar la bici
    }
}
