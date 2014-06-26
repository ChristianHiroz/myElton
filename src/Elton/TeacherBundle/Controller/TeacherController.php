<?php

namespace Elton\TeacherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Elton\DivisionBundle\Form\DivisionType;
use Elton\DivisionBundle\Entity\Division;

/**
 * Teacher controller.
 *
 * @Route("/teacher")
 */
class TeacherController extends Controller
{   
    /**
     * Create a division for the teacher
     * 
     * @Route("/create/division", name="teacher_create_division")
     * @Method("POST")
     */
    public function createDivisionAction()
    {
        $user = $this->get('elton.teacher.manager')->getCurrentUser();
        $division = new Division();
        $form = $this->createForm(new DivisionType(), $division, array(
            'action' => $this->generateUrl('teacher_create_division'),
            'method' => 'POST',
        ));
        $request = $this->get('request');

        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if($form->isValid())
            {
                $division->setTeacher($user);
                
                $em = $this->get('elton.division.manager');
                $em->persist($division);

                return $this->redirect($this->generateUrl("index")); 
            }

        }
        
        return $this->render('EltonDivisionBundle:Division:new.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * Update divisions of the teacher
     * 
     * @Route("/update/division/{id}", name="teacher_update_division")
     * @param type $id id of the division
     */
    public function editDivisionAction($id)
    {
        $user = $this->get('elton.teacher.manager')->getCurrentUser();
        $entity = $this->get('elton.division.manager')->getRepository()->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Classe inexistante');
        }
        $form = $this->createForm(new DivisionType(), $entity, array(
            'action' => $this->generateUrl('teacher_update_division', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        
        $deleteForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('division_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'
                ))->getForm();
        
        $form->add('submit', 'submit', array('label' => 'Modifier'));
        $request = $this->get('request');
        $form->handleRequest($request);
        if($request->getMethod() == "PUT")
        {
            if($form->isValid())
            {
                $em = $this->get('elton.division.manager');
                $em->persist($entity);

                return $this->redirect($this->generateUrl("index")); 
            }  
        }
        if($this->get('elton.teacher.manager')->isHisDivision($entity, $user))
        {
            return $this->render('EltonDivisionBundle:Division:edit.html.twig', array('edit_form' => $form->createView(), 'delete_form' => $deleteForm->createView()));
        }
        else
        {
            return $this->redirect($this->generateUrl("index")); 
        }
    }
    
    /**
     * @Route("/options", name="teacher_options")
     * @Template()
     */
    public function optionAction()
    {
        $user = $this->get('etlon.teacher.manager')->getCurrentUser();
        if(is_object($user) && $user->hasRole('ROLE_USER'))
        {
            $selectedDivision = $this->get('elton.division.manager')->getRepository()->getSelectedDivisionByTeacherId($user->getId());
            $othersDivisions = $this->get('elton.division.manager')->getRepository()->getNotSelectedDivisionByTeacherId($user->getId());
            $categorys = $this->get('elton.category.manager')->getRepository()->getCategoryByLevelId($selectedDivision[0]->getLevel()->getId());
            
            return array('user' => $user, 
                         'selectedDivision' => $selectedDivision[0], 
                         'othersDivisions' => $othersDivisions,
                         'categorys' => $categorys);          
        }
        else
        {
            return $this->redirect($this->generateUrl("index")); 
        }
    }
    
    /**
     * @Route("/options/divisions", name="teacher_options_divisions")
     * @Template()
     */
    public function optionDivisionsAction()
    {
        $user = $this->get('etlon.teacher.manager')->getCurrentUser();
        if(is_object($user) && $user->hasRole('ROLE_USER'))
        {
            $selectedDivision = $this->get('elton.division.manager')->getRepository()->getSelectedDivisionByTeacherId($user->getId());
            $othersDivisions = $this->get('elton.division.manager')->getRepository()->getNotSelectedDivisionByTeacherId($user->getId());
            $categorys = $this->get('elton.category.manager')->getRepository()->getCategoryByLevelId($selectedDivision[0]->getLevel()->getId());
            
            return array('user' => $user, 
                         'selectedDivision' => $selectedDivision[0], 
                         'othersDivisions' => $othersDivisions,
                         'categorys' => $categorys);          
        }
        else
        {
            return $this->redirect($this->generateUrl("index")); 
        }
    }
}
