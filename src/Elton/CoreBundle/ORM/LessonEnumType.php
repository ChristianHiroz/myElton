<?php
namespace Elton\CoreBundle\ORM;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;


class LessonEnumType extends Type
{
    const ENUM_NAME = 'lessonType';
    const NOTION = 'notion';
    const VOCABULAIRE = 'vocabulaire';
    const ACTIVITY = 'activités';

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "ENUM('notion', 'vocabulaire', 'activités')";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if($value == 0) $value = 'notion';
        else if($value == 1) $value = 'vocabulaire';
        else if($value == 2) $value = 'activités';
        if (!in_array($value, array(self::NOTION, self::VOCABULAIRE, self::ACTIVITY))) {
            throw new \InvalidArgumentException("Invalid status");
        }
        return $value;
    }
    
    public static function get_enum_values()
    {
        return array('notion', 'vocabulaire', 'activités');
    }

    public function getName()
    {
        return self::ENUM_NAME;
    }
}