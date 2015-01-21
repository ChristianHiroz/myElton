<?php

namespace Elton\TeacherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Elton\DivisionBundle\Form\DivisionType;
use Elton\DivisionBundle\Form\DivisionEditType;
use Elton\DivisionBundle\Entity\Division;
use Elton\TeacherBundle\Form\RegistrationEndFormType;
use Symfony\Component\HttpFoundation\Request;
use Elton\TeacherBundle\Entity\Teacher;

/**
 * Teacher controller.
 *
 */
class TeacherController extends Controller
{

    /**
     * @Route("/private", name="no_premium")
     * @Template("EltonTeacherBundle:Teacher:nopremium.html.twig")
     */
    public function noPremiumAction()
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        
        return $returnArray;
    }

    /**
     * @Route("/registerEnd/{id}", name="flyer_to_teacher")
     * @Template("EltonTeacherBundle:Teacher:registerEnd.html.twig")
     */
    public function registerEndAction($id, Request $request)
    {
        $flyer = $this->getDoctrine()->getManager()->getRepository('EltonTeacherBundle:Flyer')->find($id);
        $teacher = $this->container->get('elton.teacher.manager')->translateToTeacher($flyer);
        
        $form = $this->createCreateForm($teacher, $id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $teacher->addRole('ROLE_TEACHER');
            $teacher->addRole('ROLE_USER');
            $em->persist($teacher);
            $em->flush();
            if($teacher->getSubscriptions()->last()->getIsPaymentValid()){
                $teacher->addRole('ROLE_TEACHER_PREMIUM');
                $em->persist($teacher);
                $em->flush();
                $this->container->get('elton.mailer')->sendPaymentConfirmation($teacher);
            }
            else{
                $teacher->addRole('ROLE_TEACHER_PAYING');
                $em->persist($teacher);
                $em->flush();
                $this->container->get('elton.mailer')->sendPaymentRequest($teacher);
            }
            return $this->redirect($this->generateUrl('teacher_ask_login'));
        }

        return array(
            'entity' => $teacher,
            'form'   => $form->createView(),
        );
        
    }
    
    private function createCreateForm(Teacher $entity, $id)
    {
        $form = $this->createForm(new RegistrationEndFormType(), $entity, array(
            'action' => $this->generateUrl('flyer_to_teacher', array('id' => $id)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Suivant'));

        return $form;
    }
    
    /**
     * @Route("/accueil", name="accueil")
     * @Method({"GET"})
     * @Template("EltonCoreBundle:Core:accueil.html.twig")
     */
    public function accueilAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EltonCoreBundle:Jumbotron')->find(1);
        $returnArray = $this->get('elton.teacher.manager')->check();
        $returnArray['jumbotron'] = $entity;

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
     * @Route("/temp", name="temp")
     * @Method({"GET"})
     * @Template("EltonCoreBundle:Core:temp.html.twig")
     */
    public function tempAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EltonCoreBundle:Jumbotron')->find(1);
        $returnArray = $this->get('elton.teacher.manager')->check();
        $returnArray['jumbotron'] = $entity;

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
     * @Route("/finInscription", name="teacher_ask_login")
     * @Template("EltonTeacherBundle:Teacher:askLogin.html.twig")
     */
    public function askLoginAction()
    {
        return array();
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
        $form = $this->createForm(new DivisionEditType(), $entity, array(
            'action' => $this->generateUrl('division_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->setData($entity);
        $form->add('submit', 'submit', array('label' => 'Modifier'));

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
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
        ;
    }
    
    public function __toString() {
        return $this->username;
    }
}
