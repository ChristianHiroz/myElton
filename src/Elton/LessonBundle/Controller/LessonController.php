<?php

namespace Elton\LessonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Lesson controller.
 *
 * @Route("/lesson")
 */
class LessonController extends Controller
{
    /**
     * Finds and displays a Lesson entity.
     *
     * @Route("/{id}/{order}", name="lesson_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, $order)
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonLessonBundle:Lesson')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lesson entity.');
        }
        $returnArray['entity'] = $entity;
        $returnArray['order'] = $order;
        
        return $returnArray;
    }
    
    /**
     * @Route("validate/{id}/{bool}", name="validate_lesson", options={"expose"=true})
     */
    public function validateLessonAction($id, $bool)
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        $lesson =  $this->getDoctrine()->getEntityManager()->getRepository("EltonLessonBundle:Lesson")->find($id);
        $competences = $lesson->getCompetences();
        $division = $returnArray['selectedDivision'];
        if($bool == 0)
        {
           $division->addCompetence($competences[0]);
           $this->getDoctrine()->getEntityManager()->persist($division);
        }
        else
        {
           $division->removeCompetence($competences[0]);
           $this->getDoctrine()->getEntityManager()->persist($division);
        }
        $this->getDoctrine()->getEntityManager()->flush();
        
        return new \Symfony\Component\HttpFoundation\Response;
    }
}
