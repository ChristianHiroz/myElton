<?php
/**
 * Description of LessonManager
 *
 * @author Christian Hiroz
 */

namespace Elton\LessonBundle\Manager;

use Doctrine\ORM\EntityManager;
use Elton\CoreBundle\Manager\CoreManager as CoreManager;

class LessonManager extends CoreManager
{
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('EltonLessonBundle:Lesson');
    }
}
