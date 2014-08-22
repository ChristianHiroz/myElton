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
     * @Template("EltonDivisionBundle:Division:new.html.twig")
     */
    public function createDivisionAction()
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        $user = $this->get('security.context')->getToken()->getUser();
        $division = new Division();
        $form = $this->createForm(new DivisionType(), $division, array(
            'action' => $this->generateUrl('teacher_create_division'),
            'method' => 'POST'
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
        
        $returnArray['form'] = $form->createView();
        return $returnArray;
    }
    
    /**
     * Update divisions of the teacher
     * 
     * @Route("/update/division/{id}", name="teacher_update_division")
     * @param type $id id of the division
     */
    public function editDivisionAction($id)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $returnArray = $this->get('elton.teacher.manager')->check();
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
            $editForm = $this->createEditForm($entity);
            $deleteForm = $this->createDeleteForm($id);
            $returnArray['entity'] = $entity;
            $returnArray['form'] = $editForm->createView();
            $returnArray['delete_form'] = $deleteForm->createView();
            
            return $this->render('EltonDivisionBundle:Division:edit.html.twig', $returnArray);
        }
        else
        {
            return $this->redirect($this->generateUrl("index")); 
        }
    }
    
    /**
     * @Route("/options", name="teacher_options")
     * @Method("GET")
     * @Template()
     */
    public function optionAction()
    {
        $returnArray = $this->get('elton.teacher.manager')->check();

        if($returnArray=='')
        {
            return $this->redirect($this->generateUrl("index")); 
        }
        else
        {
            return $returnArray;
        }
    }
    
    /**
     * @Route("/options/divisions", name="teacher_options_divisions")
     * @Method("GET")
     * @Template()
     */
    public function optionDivisionsAction()
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        if($returnArray=='')
        {
            return $this->redirect($this->generateUrl("index")); 
        }
        else
        {
            return $returnArray;
        }
    }
    
   /**
    * Creates a form to edit a Division entity.
    *
    * @param Division $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Division $entity)
    {
        $form = $this->createForm(new DivisionType(), $entity, array(
            'action' => $this->generateUrl('division_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->setData($entity);
        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    
    
    /**
     * Creates a form to delete a Division entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('division_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * 
     * @Route("/modifier", name="teacher_modifier")
     * @Method("GET")
     * @Template("EltonTeacherBundle:Teacher:editPage.html.twig")
     */
    public function editPageAction()
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        
        return $returnArray;
    }
    
    public function __toString() {
        return $this->username;
    }
}
