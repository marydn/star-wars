<?php

declare(strict_types=1);

namespace StarWars\Controller;

use StarWars\Service\ApiConsumer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class JsonController extends AbstractController
{
    private $apiConsumer;

    public function __construct(ApiConsumer $apiConsumer)
    {
        $this->apiConsumer = $apiConsumer;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $endpoint = $request->query->get('endpoint');
        $response = $this->apiConsumer->consume($endpoint);

        return new JsonResponse(\json_decode($response->getBody()->getContents()));
    }
}