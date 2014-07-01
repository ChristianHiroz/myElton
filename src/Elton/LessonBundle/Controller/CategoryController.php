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
    private function check()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if(is_object($user) && $user->hasRole('ROLE_USER'))
        {
            $selectedDivision = $this->get('elton.division.manager')->getRepository()->getSelectedDivisionByTeacherId($user->getId());
            $othersDivisions = $this->get('elton.division.manager')->getRepository()->getNotSelectedDivisionByTeacherId($user->getId());
            $categorys = $this->get('elton.category.manager')->getRepository()->getCategoryByLevelId($selectedDivision[0]->getLevel()->getId());
            
            $returnArray =  array('user' => $user, 
                         'selectedDivision' => $selectedDivision[0], 
                         'othersDivisions' => $othersDivisions,
                         'categorys' => $categorys);          
        }
        
        return $returnArray;
    }
    
    /**
     * Finds and displays a Category entity.
     *
     * @Route("/category/{id}", name="category_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $returnArray = $this->check();
        
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
        $returnArray = $this->check();
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
     * @Route("/pratiquer/{levelId}", name="practice_level")
     * @Method("GET")
     * @Template("EltonLessonBundle:Category:pratiquerNiveau.html.twig")
     */
    public function pratiquerNiveauAction($levelId)
    {
        $returnArray = $this->check();
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
}
