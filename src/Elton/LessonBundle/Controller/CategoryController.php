<?php

namespace Elton\LessonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Elton\LessonBundle\Entity\Category;
use Elton\LessonBundle\Form\CategoryType;

/**
 * Category controller.
 *
 * @Route("/")
 */
class CategoryController extends Controller
{
    /**
     * Finds and displays a Category entity.
     *
     * @Route("/category/{id}", name="category_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonLessonBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }
        $returnArray['entity'] = $entity;
        
        return $returnArray;
    }

    /**
     * @Route("/pratiquer", name="practice")
     * @Method("GET")
     * @Template("EltonLessonBundle:Category:pratiquer.html.twig")
     */
    public function pratiquerAction()
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        $categorys = $this->get('elton.category.manager')->getRepository()->getCategoryByLevelName("Commun");
        if($returnArray=='')
        {
            return $this->redirect($this->generateUrl("index")); 
        }
        else
        {
            $returnArray['categorys'] = $categorys;
            
            return $returnArray;
        }
    }
    
    /**
     * @Route("/culture", name="culture")
     * @Method("GET")
     * @Template("EltonLessonBundle:Category:culture.html.twig")
     */
    public function cultureAction()
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        
        return $returnArray;
    }
    
    /**
     * @Route("/pratiquer/{levelId}", name="practice_level")
     * @Method("GET")
     * @Template("EltonLessonBundle:Category:pratiquerNiveau.html.twig")
     */
    public function pratiquerNiveauAction($levelId)
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        $categorys = $this->get('elton.category.manager')->getRepository()->getCategoryByLevelId($levelId);
        if($returnArray=='')
        {
            return $this->redirect($this->generateUrl("index")); 
        }
        else
        {
            $returnArray['categorys'] = $categorys;
            
            return $returnArray;
        }
    }
    
    /**
     * @Route("/monthlyEvent", name="monthly_event")
     * @Method("GET")
     */
    public function monthlyEvent()
    {
        $lesson = $this->get('elton.lesson.manager')->getRepository()->findLastLessonOfMonthlyEventCategory();
        
        return $this->redirect($this->generateUrl("lesson_show", array('id' => $lesson->getId(), 'order' => '1')));
    }
    
    /**
     * @Route("/culturalEvent", name="cultural_event")
     * @Method("GET")
     * @Template("EltonLessonBundle:Category:world.html.twig")
     */
    public function culturalEventAction()
    {
        $categorys = $this->get('elton.category.manager')->getRepository()->getCategoryByLevelName("Culture");
        $returnArray = $this->get('elton.teacher.manager')->check();
        
        $returnArray['categorys'] = $categorys;
        
        return $returnArray;
    }
}
