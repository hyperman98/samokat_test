<?php

declare(strict_types=1);

namespace App\Controller;

use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ParcelDeleteController extends AbstractController
{
    #[OA\Tag(name: 'Parcel')]
    #[Route('/api/parcel', name: 'app_parcel_delete', methods: 'DELETE')]
    public function __invoke(): JsonResponse
    {
        return $this->json([
            'message' => 'Необходимо реализовать',
        ]);
    }
}
