<?php

declare(strict_types=1);

namespace Vanmoof\Adapters\Controllers;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\Routing\Annotation\Route;
use Vanmoof\Application\Domain\SorryBikeNotFound;
use Vanmoof\Application\Dto\BikeDtoRequest;
use Vanmoof\Application\Services\ActivateBikeForUser;
use Vanmoof\Application\Services\ArchiveBikeForUser;
use Vanmoof\Application\Services\CreateBikeForUser;
use Vanmoof\Application\Services\DeactivateBikeForUser;
use Vanmoof\Application\Services\DeleteBikeForUser;
use Vanmoof\Application\Services\GetAllBikesForUser;
use Vanmoof\Application\Services\GetBikeForUser;
use Vanmoof\Application\Services\UpdateBikeInformationForUser;

final class BikeController
{
    public function __construct
    (
        private CreateBikeForUser            $createBikeForUser,
        private ArchiveBikeForUser           $archiveBikeForUser,
        private DeleteBikeForUser            $deleteBikeForUser,
        private UpdateBikeInformationForUser $updateBikeInformationForUser,
        private ActivateBikeForUser          $activateBikeForUser,
        private DeactivateBikeForUser        $deactivateBikeForUser,
        private GetBikeForUser               $getBikeForUser,
        private GetAllBikesForUser           $getAllBikesForUser,
        private DataValidator                $dataValidator,
    )
    {
    }

    #[Route('/api/v1/bike/{bikeId}/user/{userId}', name: 'get-bike', methods: ['GET'])]
    public function get(Request $request): HttpResponse
    {
        $userId = $request->attributes->get('userId');
        $bikeId = $request->attributes->get('bikeId');

        try {
            $this->dataValidator->validateData($userId, $bikeId,);
        } catch (Exception) {
            return new JsonResponse([], HttpResponse::HTTP_BAD_REQUEST);
        }

        $bikeDtoRequest = new BikeDtoRequest(
            $userId,
            $bikeId,
        );

        try {
            $bikeDto = $this->getBikeForUser->forUserId(
                $bikeDtoRequest
            );
        } catch (SorryBikeNotFound) {
            return new JsonResponse([], HttpResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($bikeDto->toArray(), HttpResponse::HTTP_OK);
    }


    #[Route('/api/v1/bikes/user/{userId}', name: 'get-all-bikes', methods: ['GET'])]
    public function getAll(Request $request): HttpResponse
    {
        $userId = $request->attributes->get('userId');

        try {
            $this->dataValidator->validateData($userId,);
        } catch (Exception) {
            return new JsonResponse([], HttpResponse::HTTP_BAD_REQUEST);
        }

        $bikeDtoRequest = new BikeDtoRequest($userId,);

        try {
            $bikeDtoArray = $this->getAllBikesForUser->getAll($bikeDtoRequest);
        } catch (SorryBikeNotFound) {
            return new JsonResponse([], HttpResponse::HTTP_NOT_FOUND);
        }

        $responseArray = [];

        foreach ($bikeDtoArray as $bikeDtoResponse) {
            $responseArray[] = $bikeDtoResponse->toArray();
        }

        return new JsonResponse($responseArray, HttpResponse::HTTP_OK);
    }

    #[Route('/api/v1/bike/{bikeId}/user/{userId}', name: 'delete-bike', methods: ['DELETE'])]
    public function delete(Request $request): HttpResponse
    {
        $userId = $request->attributes->get('userId');
        $bikeId = $request->attributes->get('bikeId');

        try {
            $this->dataValidator->validateData($userId, $bikeId,);
        } catch (Exception) {
            return new JsonResponse([], HttpResponse::HTTP_BAD_REQUEST);
        }

        $bikeDtoRequest = new BikeDtoRequest(
            $userId,
            $bikeId,
        );

        try {
            $this->deleteBikeForUser->delete(
                $bikeDtoRequest
            );
        } catch (SorryBikeNotFound) {
            return new JsonResponse([], HttpResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['Id of deleted Bike' => $bikeDtoRequest->getBikeId()], HttpResponse::HTTP_OK);
    }

    #[Route('/api/v1/bike/activate', name: 'activate-bike', methods: ['PATCH'])]
    public function activate(Request $request): HttpResponse
    {
        $userId = $request->get('userId');
        $bikeId = $request->get('bikeId');

        try {
            $this->dataValidator->validateData($userId, $bikeId,);
        } catch (Exception) {
            return new JsonResponse([], HttpResponse::HTTP_BAD_REQUEST);
        }

        $bikeDtoRequest = new BikeDtoRequest($userId, $bikeId,);

        try {
            $bikeDto = $this->activateBikeForUser->activate($bikeDtoRequest);
        } catch (SorryBikeNotFound) {
            return new JsonResponse([], HttpResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($bikeDto->toArray(), HttpResponse::HTTP_OK);
    }

    #[Route('/api/v1/bike/deactivate', name: 'deactivate-bike', methods: ['PATCH'])]
    public function deactivate(Request $request): HttpResponse
    {
        $userId = $request->get('userId');
        $bikeId = $request->get('bikeId');

        try {
            $this->dataValidator->validateData($userId, $bikeId,);
        } catch (Exception) {
            return new JsonResponse([], HttpResponse::HTTP_BAD_REQUEST);
        }

        $bikeDtoRequest = new BikeDtoRequest(
            $userId,
            $bikeId,
        );

        try {
            $bikeDto = $this->deactivateBikeForUser->deactivate(
                $bikeDtoRequest
            );
        } catch (SorryBikeNotFound) {
            return new JsonResponse([], HttpResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($bikeDto->toArray(), HttpResponse::HTTP_OK);
    }

    #[Route('/api/v1/bike/archive', name: 'archive-bike', methods: ['PATCH'])]
    public function archive(Request $request): HttpResponse
    {
        $userId = $request->get('userId');
        $bikeId = $request->get('bikeId');

        try {
            $this->dataValidator->validateData($userId, $bikeId,);
        } catch (Exception) {
            return new JsonResponse([], HttpResponse::HTTP_BAD_REQUEST);
        }

        $bikeDtoRequest = new BikeDtoRequest(
            $userId,
            $bikeId,
        );

        try {
            $bikeDto = $this->archiveBikeForUser->archive($bikeDtoRequest);
        } catch (SorryBikeNotFound) {
            return new JsonResponse([], HttpResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($bikeDto->toArray(), HttpResponse::HTTP_OK);
    }

    #[Route('/api/v1/bike', name: 'create-bike', methods: ['POST'])]
    public function create(Request $request): HttpResponse
    {
        $userId = $request->get('userId');

        try {
            $this->dataValidator->validateData($userId,);
        } catch (Exception) {
            return new JsonResponse([], HttpResponse::HTTP_BAD_REQUEST);
        }

        $bikeDtoRequest = new BikeDtoRequest($userId);

        try {
            $bikeDto = $this->createBikeForUser->create($bikeDtoRequest);
        } catch (SorryBikeNotFound) {
            return new JsonResponse([], HttpResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($bikeDto->toArray(), HttpResponse::HTTP_OK);
    }

    #[Route('/api/v1/bike', name: 'update-bike', methods: ['PUT'])]
    public function update(Request $request): HttpResponse
    {
        $userId = $request->get('userId');
        $bikeId = $request->get('bikeId');
        $name = $request->get('name');
        $model = $request->get('model') !== "" ? (int)$request->get('model') : null;

        try {
            $this->dataValidator->validateData($userId, $bikeId, $name, $model);
        } catch (Exception) {
            return new JsonResponse([], HttpResponse::HTTP_BAD_REQUEST);
        }

        $bikeDtoRequest = new BikeDtoRequest($userId, $bikeId, $name, $model);

        try {
            $bikeDto = $this->updateBikeInformationForUser->update($bikeDtoRequest);
        } catch (SorryBikeNotFound) {
            return new JsonResponse([], HttpResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse($bikeDto->toArray(), HttpResponse::HTTP_OK);
    }
}
