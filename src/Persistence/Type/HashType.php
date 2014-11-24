<?php

namespace Martha\Core\Persistence\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Martha\Core\Hash;

/**
 * Class Hash
 * @package Martha\Core\Persistence\HashType
 */
class HashType extends Type
{
    const HASH = 'hash';

    /**
     * {@inheritDoc}
     */
    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'text';
    }

    /**
     * {@inheritDoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value ? new Hash(json_decode($value, true)) : new Hash();
    }

    /**
     * {@inheritDoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Hash ? $value->toJson() : null;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::HASH;
    }
}
