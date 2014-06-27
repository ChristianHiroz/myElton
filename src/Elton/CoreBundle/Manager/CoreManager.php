<?php
/**
 * Description of CoreManager
 *
 * @author Christian Hiroz
 */
namespace Elton\CoreBundle\Manager;

abstract class CoreManager
{
    public function persist($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
}
