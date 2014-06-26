<?php
/**
 * Description of TeacherManager
 *
 * @author Christian Hiroz
 */

namespace Elton\TeacherBundle\Manager;

use Doctrine\ORM\EntityManager;
use Elton\CoreBundle\Manager\CoreManager as CoreManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class TeacherManager extends CoreManager
{
    protected $em;
    private $container;
    
    public function __construct(EntityManager $em, Container $container)
    {
        $this->em = $em;
        $this->container = $container;
    }
    
    public function getRepository()
    {
        return $this->em->getRepository('EltonTeacherBundle:Teacher');
    }
    
    public function isHisDivision($division, $teacher)
    {
        foreach($teacher->getDivisions() as $div)
        {
            if($div == $division)
            {
                return true;
            }
        }
        return false;
    }
    
    public function getCurrentUser()
    {
        return $this->get('security.context')->getToken()->getUser();
    }

}
