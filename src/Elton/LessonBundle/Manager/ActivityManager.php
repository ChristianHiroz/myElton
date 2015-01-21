<?php
/**
 * Description of ActivityManager
 *
 * @author Christian Hiroz
 */

namespace Elton\LessonBundle\Manager;

use Doctrine\ORM\EntityManager;
use Elton\CoreBundle\Manager\CoreManager as CoreManager;

class ActivityManager extends CoreManager
{
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('EltonLessonBundle:Activity');
    }
}
