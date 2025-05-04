<?php

declare(strict_types=1);

namespace App\Domain\Doctrine\Type;

use App\Domain\Exception\Serializer\SerializerNotSetException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Extend this class to create a new JSON strict typed-object type for Doctrine.
 * Call static method `setSerializer` with a Symfony Serializer instance to set the serializer before use.
 * Add the new type as doctrine.dbal.types to config/packages/doctrine.yaml to register it.
 */
abstract class AbstractJsonObjectType extends JsonType
{
    abstract protected function getTypeName(): string;

    /**
     * @return class-string|string
     */
    abstract protected function getObjectClass(): string;

    private static ?SerializerInterface $serializer = null;

    public static function setSerializer(SerializerInterface $serializer): void
    {
        self::$serializer = $serializer;
    }

    public function getName(): string
    {
        return $this->getTypeName();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (self::$serializer === null) {
            throw new SerializerNotSetException();
        }

        if ($value === null || $value === '') {
            return null;
        }

        return self::$serializer->deserialize($value, $this->getObjectClass(), 'json');
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (self::$serializer === null) {
            throw new SerializerNotSetException();
        }

        if ($value === null) {
            return null;
        }

        return self::$serializer->serialize($value, 'json');
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
