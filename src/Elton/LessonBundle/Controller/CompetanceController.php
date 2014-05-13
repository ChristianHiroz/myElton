<?php

namespace Elton\LessonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Elton\LessonBundle\Entity\Competance;
use Elton\LessonBundle\Form\CompetanceType;

/**
 * Competance controller.
 *
 * @Route("/competance")
 */
class CompetanceController extends Controller
{

    /**
     * Lists all Competance entities.
     *
     * @Route("/", name="competance")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EltonLessonBundle:Competance')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Competance entity.
     *
     * @Route("/", name="competance_create")
     * @Method("POST")
     * @Template("EltonLessonBundle:Competance:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Competance();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('competance_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Competance entity.
    *
    * @param Competance $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Competance $entity)
    {
        $form = $this->createForm(new CompetanceType(), $entity, array(
            'action' => $this->generateUrl('competance_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Competance entity.
     *
     * @Route("/new", name="competance_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Competance();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Competance entity.
     *
     * @Route("/{id}", name="competance_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonLessonBundle:Competance')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Competance entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Competance entity.
     *
     * @Route("/{id}/edit", name="competance_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonLessonBundle:Competance')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Competance entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Competance entity.
    *
    * @param Competance $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Competance $entity)
    {
        $form = $this->createForm(new CompetanceType(), $entity, array(
            'action' => $this->generateUrl('competance_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Competance entity.
     *
     * @Route("/{id}", name="competance_update")
     * @Method("PUT")
     * @Template("EltonLessonBundle:Competance:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonLessonBundle:Competance')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Competance entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('competance_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Competance entity.
     *
     * @Route("/{id}", name="competance_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EltonLessonBundle:Competance')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Competance entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('competance'));
    }

    /**
     * Creates a form to delete a Competance entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('competance_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
