<?php

declare(strict_types=1);

namespace App\Controller;

use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ParcelAddController extends AbstractController
{
    #[OA\Tag(name: 'Parcel')]
    #[Route('/api/parcel', name: 'api_parcel_add', methods: 'POST')]
    public function __invoke(): JsonResponse
    {
        return $this->json([
            'message' => 'Необходимо реализовать',
        ]);
    }
}
