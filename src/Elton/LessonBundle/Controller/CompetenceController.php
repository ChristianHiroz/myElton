<?php

namespace Elton\LessonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Competence controller.
 *
 * @Route("/")
 */
class CompetenceController extends Controller
{
    /**
     * @Route("/acquis", name="acquis")
     * @Method("GET")
     * @Template("EltonLessonBundle:Competence:acquis.html.twig")
     */
    public function acquisAction()
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        $competences = $this->getDoctrine()->getRepository("EltonLessonBundle:Competence")->findAll();
        if($returnArray=='')
        {
            return $this->redirect($this->generateUrl("index")); 
        }
        else
        {
            $returnArray['competences'] = $competences;
            
            return $returnArray;
        }
    }
}
