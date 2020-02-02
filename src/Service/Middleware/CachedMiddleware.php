<?php

declare(strict_types=1);

namespace StarWars\Service\Middleware;

use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Promise\RejectedPromise;
use Psr\Http\Message\{
    RequestInterface, ResponseInterface
};
use StarWars\Service\RedisCache;

final class CachedMiddleware
{
    public const CACHE_TIME_IN_SECONDS = 'cache_time';
    private const DEFAULT_CACHE_TIME = 5;

    public function onRequest(RedisCache $cache, int $defaultCacheTime = self::DEFAULT_CACHE_TIME)
    {
        return function (callable $handler) use ($cache, $defaultCacheTime) {
            return function (RequestInterface $request, array $options) use ($handler, $cache, $defaultCacheTime) {
                $cacheKey  = sha1((string) $request->getUri());
                $cacheTime = $options[self::CACHE_TIME_IN_SECONDS] ?? $defaultCacheTime;

                $cachedResponse = $cache->getObject($cacheKey);
                if ($cachedResponse) {
                    return new FulfilledPromise($cachedResponse);
                }

                $cache->invalidate($cacheKey);

                return $handler($request, $options)->then(
                    function (ResponseInterface $response) use ($cache, $cacheKey, $cacheTime) {
                        if ($response->getStatusCode() === 200) {
                            $cache->setObject($cacheKey, $response, $cacheTime);
                        }

                        return $response;
                    },
                    function (TransferException $e) {
                        return new RejectedPromise($e);
                    }
                );
            };
        };
    }
}