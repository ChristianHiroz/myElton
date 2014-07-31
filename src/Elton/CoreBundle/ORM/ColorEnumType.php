<?php
namespace Elton\CoreBundle\ORM;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;


class ColorEnumType extends Type
{
    const ENUM_NAME = 'color';
    const BLUE = 'bleu';
    const RED = 'rouge';
    const BLACK = 'noir';
    const GREY = 'gris';
    const ORANGE = 'orange';
    const VIOLET = 'violet';
    const BEIGE = 'beige';
    const TURQUOISE = 'turquoise';
    const BLEUF = 'bleu foncé';

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return "ENUM('bleu', 'rouge', 'noir', 'gris', 'orange', 'violet', 'beige', 'turquoise', 'bleufonce')";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if($value == 0) $value = 'bleu';
        else if($value == 1) $value = 'rouge';
        else if($value == 2) $value = 'noir';
        else if($value == 3) $value = 'gris';
        else if($value == 4) $value = 'orange';
        else if($value == 5) $value = 'violet';
        else if($value == 6) $value = 'beige';
        else if($value == 7) $value = 'turquoise';
        else if($value == 8) $value = 'bleufonce';
        else if (!in_array($value, array(self::RED, self::BLUE, self::BLACK, self::GREY, self::ORANGE, self::VIOLET, self::BEIGE, self::TURQUOISE, self::BLEUF))) {
            throw new \InvalidArgumentException("Invalid status");
        }
        return $value;
    }
    
    public static function get_enum_values()
    {
        return array('bleu', 'rouge', 'noir', 'gris', 'orange', 'violet', 'beige', 'turquoise', 'bleufonce');
    }

    public function getName()
    {
        return self::ENUM_NAME;
    }
}