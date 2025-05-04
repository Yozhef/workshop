<?php

declare(strict_types=1);

namespace App\Infrastructure\Bootstrap;

use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeZoneNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\UidNormalizer;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class DoctrineTypesBootstrap
{
    public function setSerializer(): void
    {
        // list of types that need to be set from App\Domain\Doctrine\Type
        // and call ::setSerializer($this->getSerializer())
    }

    public function getSerializer(): SerializerInterface
    {
        return new Serializer(
            [
                new UnwrappingDenormalizer(),
                new UidNormalizer(),
                new DateTimeNormalizer(),
                new DateTimeZoneNormalizer(),
                new BackedEnumNormalizer(),
                new ArrayDenormalizer(),
                new ObjectNormalizer(
                    propertyTypeExtractor: new ReflectionExtractor(),
                ),
            ],
            [
                new JsonEncoder(),
            ],
        );
    }
}
