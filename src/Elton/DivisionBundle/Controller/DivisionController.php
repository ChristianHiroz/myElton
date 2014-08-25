<?php

namespace Elton\DivisionBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Elton\DivisionBundle\Entity\Division;
use Elton\DivisionBundle\Form\DivisionType;
use Elton\CoreBundle\Form\IntegerType;

/**
 * Division controller.
 *
 * @Route("/division")
 */
class DivisionController extends Controller
{

    /**
     * Lists all Division entities.
     *
     * @Route("/", name="base_division")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $division = $this->get('security.context')->getToken()->getUser();
        return array('user' => $division);
    }
    
    /**
     * Show division by their  level
     * 
     * @Route("/findByLevel/{level}", name="division_by_level")
     * @Method("GET")
     * @Template()
     */
    public function levelAction($level)
    {
        $divisions = $this->get('elton.division.manager')->getRepository()->getDivisionByLevel($level);
        $level = $this->get('elton.level.manager')->getRepository()->findById($level);
        
        return array('divisions' => $divisions, 'level' => $level[0]);
    }
    
    /**
     * To search division by teacher Id
     * 
     * @Route("/byTeacherId", name="division_by_teacherId")
     * @Method("PUT")
     * @Template()
     */
    public function searchByTeacherIdAction()
    {
        $form = $this->createForm(new IntegerType());
        $request = $this->get('request');

        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if($form->isValid())
            {
                $teacherId = $form->get('id')->getData();
                try
                {
                    $teacher = $this->get('elton.teacher.manager')->getRepository()->find($teacherId);
                    $divisions = $teacher->getDivisions();
                    if($divisions == null)
                    {
                        throw new \Doctrine\ORM\NoResultException();
                    }
                }
                catch(\Doctrine\ORM\NoResultException $ex)
                {
                    return $this->render('EltonCoreBundle:Error:BackOffice/notFound.html.twig');
                }
                
                return $this->render('EltonDivisionBundle:Division:index.html.twig', array(
                    'entities' => $divisions));
            }
        }
        
        return $this->render('EltonCoreBundle:Core:id.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * Creates a new Division entity.
     *
     * @Route("/", name="division_create")
     * @Method("POST")
     * @Template("EltonDivisionBundle:Division:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Division();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('division_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Division entity.
    *
    * @param Division $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Division $entity)
    {
        $form = $this->createForm(new DivisionType(), $entity, array(
            'action' => $this->generateUrl('division_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Division entity.
     *
     * @Route("/new", name="division_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Division();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Division entity.
     *
     * @Route("/{id}", name="division_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonDivisionBundle:Division')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Division entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Division entity.
     *
     * @Route("/{id}/edit", name="division_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonDivisionBundle:Division')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Division entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        $returnArray['entity'] = $entity;
        $returnArray['form'] = $editForm;
        $returnArray['delete_form'] = $deleteForm;
        
        return $returnArray;
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

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Division entity.
     *
     * @Route("/{id}", name="division_update")
     * @Method("PUT")
     * @Template("EltonDivisionBundle:Division:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonDivisionBundle:Division')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Division entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('teacher_options_divisions'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Division entity.
     *
     * @Route("/{id}", name="division_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EltonDivisionBundle:Division')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Division entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('teacher_options_divisions'));
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
     * Change the selectedDivision
     * 
     * @param int $id The entity id
     * @Route("/change/{id}", name="division_change")
     */
    public function divisionChangeAction($id)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if(is_object($user) && $user->hasRole('ROLE_USER'))
        {
            $oldSelectedDivision = $this->get('elton.division.manager')->getRepository()->getSelectedDivisionByTeacherId($user->getId());
            $newSelectedDivision = $this->get('elton.division.manager')->getRepository()->findById($id);
            $oldSelectedDivision[0]->setSelected(false);
            $newSelectedDivision[0]->setSelected(true);
            $this->get('elton.division.manager')->persist($newSelectedDivision[0]);
            $this->get('elton.division.manager')->persist($oldSelectedDivision[0]);
            
            return $this->redirect($this->generateUrl('index'));
        }
    }
}