<?php

declare(strict_types=1);

namespace StarWars\Service\Normalizer;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use PHPUnit\Util\Json;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use function GuzzleHttp\Psr7\parse_response as UnserializeResponse;
use function GuzzleHttp\Psr7\str as SerializeResponse;

final class GuzzleResponseNormalizer implements NormalizerInterface, DenormalizerInterface
{
    private $jsonEncoder;

    public function __construct()
    {
        $this->jsonEncoder = new JsonEncoder();
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        $messageToString = SerializeResponse($object);

        return $messageToString;
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $stringToMessage = UnserializeResponse($data);

        return $stringToMessage;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof GuzzleResponse && $format === 'json';
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === GuzzleResponse::class && $format === 'json';
    }
}