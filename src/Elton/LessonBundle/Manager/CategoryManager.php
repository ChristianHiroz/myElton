<?php
/**
 * Description of CategoryManager
 *
 * @author Christian Hiroz
 */

namespace Elton\LessonBundle\Manager;

use Doctrine\ORM\EntityManager;
use Elton\CoreBundle\Manager\CoreManager as CoreManager;

class CategoryManager extends CoreManager
{
    protected $em;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('EltonLessonBundle:Category');
    }   
}
