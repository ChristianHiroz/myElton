<?php
/**
 * Description of TeacherManager
 *
 * @author Christian Hiroz
 */

namespace Elton\TeacherBundle\Manager;

use Doctrine\ORM\EntityManager;
use Elton\CoreBundle\Manager\CoreManager as CoreManager;

class TeacherManager extends CoreManager
{
    protected $em;
    protected $container;


    public function __construct(EntityManager $em, \Symfony\Component\DependencyInjection\Container $container)
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
    
    public function check()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if(is_object($user) && $user->hasRole('ROLE_USER'))
        {
            $selectedDivision = $this->container->get('elton.division.manager')->getRepository()->getSelectedDivisionByTeacherId($user->getId());
            if(array_key_exists(0, $selectedDivision))
            {    
                $cartNumber = $selectedDivision[0]->getCart()->getActivitys()->count();
            }
            else
            {
                $selectedDivision[0] = 0;
                $cartNumber = 0;
            }
            $othersDivisions = $this->container->get('elton.division.manager')->getRepository()->getNotSelectedDivisionByTeacherId($user->getId());
            
            $returnArray =  array('user' => $user, 
                         'selectedDivision' => $selectedDivision[0], 
                         'othersDivisions' => $othersDivisions,
                         'cartNumber' => $cartNumber);          
        }
        else
        {
            $returnArray = array('selectedDivision' => 0);
        }
        
        return $returnArray;
    }

}
