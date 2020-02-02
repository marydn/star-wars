<?php

declare(strict_types=1);

namespace StarWars\Service;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Symfony\Component\Serializer\SerializerInterface;

final class RedisCache
{
    private const SERIALIZER_FORMAT = 'json';
    private const SERIALIZER_TYPE = 'array';

    private $redisClient;
    private $serializer;

    public function __construct(\Redis $redisClient, SerializerInterface $serializer)
    {
        $this->redisClient = $redisClient;
        $this->serializer  = $serializer;
    }

    public function get($key)
    {
        $this->redisClient->get($key);
    }

    public function invalidate($key)
    {
        $this->redisClient->del(array($key));
    }

    public function set($key, $value, $ttl = 0): bool
    {
        if ($ttl > 0) {
            return $this->redisClient->setex($key, $ttl, $value);
        }

        return $this->redisClient->set($key, $value);
    }

    public function setObject($key, $value, $ttl = 0): bool
    {
        $serialized = $this->serializer->serialize($value, self::SERIALIZER_FORMAT);

        return $this->set($key, $serialized, $ttl);
    }

    public function getObject($key): ?object
    {
        $object = $this->redisClient->get($key);
        if (!$object) {
            return null;
        }

        return $this->serializer->deserialize($object, GuzzleResponse::class, self::SERIALIZER_FORMAT);
    }
}