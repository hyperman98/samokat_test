<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\ParcelDto;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ParcelSearchController extends AbstractController
{
    #[OA\Response(
        response: 200,
        description: 'Returns the rewards of an user',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: ParcelDto::class, groups: ['full']))
        )
    )]
    #[OA\Parameter(
        name: 'searchType',
        in: 'query',
        description: 'Поле используется для определения типа поиска. Допустимые значения sender_phone и receiver_fullname',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Parameter(
        name: 'q',
        in: 'query',
        description: 'Поле используется для поиска по заданному значению',
        schema: new OA\Schema(type: 'string')
    )]
    #[OA\Tag(name: 'Parcel')]
    #[Route('/api/parcel', name: 'app_parcel_search', methods: 'GET')]
    public function __invoke(): JsonResponse
    {
        return $this->json([
            'message' => 'Необходимо реализовать',
        ]);
    }
}
