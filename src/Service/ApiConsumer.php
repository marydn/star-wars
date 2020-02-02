<?php

declare(strict_types=1);

namespace StarWars\Service;

use GuzzleHttp\ClientInterface as HttpClientInterface;
use Psr\Http\Message\ResponseInterface;
use StarWars\Service\Middleware\CachedMiddleware;

final class ApiConsumer
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function consume($endpoint, ?int $cachedTime = null): ResponseInterface
    {
        return $this->httpClient->request('GET', $endpoint, array(
            CachedMiddleware::CACHE_TIME_IN_SECONDS => $cachedTime
        ));
    }
}