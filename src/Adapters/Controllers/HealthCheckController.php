<?php

declare(strict_types=1);

namespace Vanmoof\Adapters\Controllers;

use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

final class HealthCheckController
{
    #[Route('/api/v1/health', name: 'health-check', methods: ['GET'])]
    public function getHealthCheck(): HttpResponse
    {
        return new JsonResponse(['status' => 'OK'], HttpResponse::HTTP_OK);
    }
}
