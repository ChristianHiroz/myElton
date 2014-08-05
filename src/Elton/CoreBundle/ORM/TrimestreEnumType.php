<?php
namespace Elton\CoreBundle\ORM;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;


class TrimestreEnumType extends Type
{
    const ENUM_NAME = 'trimestreType';
    const UN = 'Premier trimestre';
    const DEUX = 'Second trimestre';
    const TROIS = 'Troisième trimestre';

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "ENUM('Premier trimestre', 'Second trimestre', 'Troisième trimestre')";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if($value == 0) $value = 'Premier trimestre';
        else if($value == 1) $value = 'Second trimestre';
        else if($value == 2) $value = 'Troisième trimestre';
        if (!in_array($value, array(self::UN, self::DEUX, self::TROIS))) {
            throw new \InvalidArgumentException("Invalid status");
        }
        return $value;
    }
    
    public static function get_enum_values()
    {
        return array('Premier trimestre', 'Second trimestre', 'Troisième trimestre');
    }

    public function getName()
    {
        return self::ENUM_NAME;
    }
}