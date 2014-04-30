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
     * @Route("/backOffice", name="backOffice")
     * @Template("EltonCoreBundle:Core:backOffice.html.twig")
     */
    public function backOfficeAction()
    {
        return array();
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
        return array();
    }
}
