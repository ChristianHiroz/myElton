<?php
namespace Elton\CoreBundle\ORM;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;


class ActivityEnumType extends Type
{
    const ENUM_NAME = 'activityType';
    const PHYSIQUE = 'physique';
    const IANDS = 'IetS';
    const NUMERIQUE = 'numérique';

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "ENUM('physique', 'IetS', 'numérique')";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if($value == 0) $value = 'physique';
        else if($value == 1) $value = 'IetS';
        else if($value == 2) $value = 'numérique';
        if (!in_array($value, array(self::PHYSIQUE, self::IANDS, self::NUMERIQUE))) {
            throw new \InvalidArgumentException("Invalid status");
        }
        return $value;
    }
    
    public static function get_enum_values()
    {
        return array('physique', 'IetS', 'numérique');
    }

    public function getName()
    {
        return self::ENUM_NAME;
    }
}