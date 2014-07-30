<?php

namespace Elton\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\DBAL\Types\Type;

class EltonCoreBundle extends Bundle
{
    public function boot()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');

        // Ajout des nouveaux types à notre entity manager
        Type::addType('color', 'Elton\CoreBundle\ORM\ColorEnumType');
        Type::addType('lessonType', 'Elton\CoreBundle\ORM\LessonEnumType');
        Type::addType('activityType', 'Elton\CoreBundle\ORM\ActivityEnumType');
        $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('color', 'color');
        $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('lessonType', 'lessonType');
        $em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('activityType', 'activityType');
    }
}
