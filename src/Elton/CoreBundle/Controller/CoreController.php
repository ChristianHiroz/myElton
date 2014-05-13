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
     * @Route("/backOffice", name="back_office")
     * @Template("EltonCoreBundle:Core:backOffice.html.twig")
     */
    public function backOfficeAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if(is_object($user) && $user->hasRole('ROLE_ADMIN'))
        {
            return $this->redirect($this->generateUrl('sonata_admin_dashboard'));
        }
        else
        {
            return $this->redirect($this->generateUrl('index'));
        }
    }
    
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
            if($user->hasRole('ROLE_ADMIN'))
            {
                return array('user' => $user,);
            }
//            $selectedDivision = $this->get('elton.division.manager')->getRepository()->getSelectedDivisionByTeacherId($user->getId());
//            $othersDivisions = $this->get('elton.division.manager')->getRepository()->getNonSelectedDivisionByTeacherId($user->getId());
//            $categorys = $this->get('elton.category.manager')->getRepository()->getCategoryByLevelId($selectedDivision->getLevel()->getId());
//            //RETURN SI PAS DE DIVISION TO CREATE DIVISION
//            
//            return array('user' => $user, 
//                         'selectedDivision' => $selectedDivision, 
//                         'othersDivisions' => $othersDivisions,
//                         'categorys' => $categorys);                
             return array('user' => $user,);
        }
        else
        {
            return array('user' => $user,);
        }
    }
}
