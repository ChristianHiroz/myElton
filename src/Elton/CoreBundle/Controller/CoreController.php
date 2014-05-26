<?php

namespace Elton\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Elton\CoreBundle\Entity\File;
use Elton\CoreBundle\Form\FileType;

/**
 * Core controller
 * 
 */
class CoreController extends Controller
{
    /**
     * @Route("/stats", name="stats")
     * @Template("EltonCoreBundle:Core:stats.html.twig")
     */
    public function statistiqueAction()
    {
        $nbTeachers = $this->get('elton.teacher.manager')->getRepository()->count();
        $nbDivisions = $this->get('elton.division.manager')->getRepository()->count();
        $nbLessons = $this->get('elton.lesson.manager')->getRepository()->count();
        $nbFiles = $this->get('elton.file.manager')->getRepository()->count();
        
        return array('nbT' => $nbTeachers[1], 'nbD' => $nbDivisions[1], 'nbL' => $nbLessons[1], 'nbF' => $nbFiles[1]);
    }
    
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if(is_object($user) && $user->hasRole('ROLE_USER'))
        {
            $selectedDivision = $this->get('elton.division.manager')->getRepository()->getSelectedDivisionByTeacherId($user->getId());
            if($selectedDivision == null)
            {
                return $this->redirect($this->generateUrl("teacher_create_division")); 
            }
            $othersDivisions = $this->get('elton.division.manager')->getRepository()->getNotSelectedDivisionByTeacherId($user->getId());
            $categorys = $this->get('elton.category.manager')->getRepository()->getCategoryByLevelId($selectedDivision[0]->getLevel()->getId());
            
            return array('user' => $user, 
                         'selectedDivision' => $selectedDivision[0], 
                         'othersDivisions' => $othersDivisions,
                         'categorys' => $categorys);          
        }
        else
        {
            return array('user' => $user,);
        }
    }
}
