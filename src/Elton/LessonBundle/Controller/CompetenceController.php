<?php

namespace Elton\LessonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Elton\LessonBundle\Entity\Competence;
use Elton\LessonBundle\Form\CompetenceType;

/**
 * Competence controller.
 *
 * @Route("/competence")
 */
class CompetenceController extends Controller
{

    /**
     * Lists all Competence entities.
     *
     * @Route("/", name="competence")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EltonLessonBundle:Competence')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Competence entity.
     *
     * @Route("/", name="competence_create")
     * @Method("POST")
     * @Template("EltonLessonBundle:Competence:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Competence();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('competence_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Competence entity.
    *
    * @param Competence $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Competence $entity)
    {
        $form = $this->createForm(new CompetenceType(), $entity, array(
            'action' => $this->generateUrl('competence_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Competence entity.
     *
     * @Route("/new", name="competence_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Competence();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Competence entity.
     *
     * @Route("/{id}", name="competence_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonLessonBundle:Competence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Competence entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Competence entity.
     *
     * @Route("/{id}/edit", name="competence_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonLessonBundle:Competence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Competence entity.');
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
    * Creates a form to edit a Competence entity.
    *
    * @param Competence $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Competence $entity)
    {
        $form = $this->createForm(new CompetenceType(), $entity, array(
            'action' => $this->generateUrl('competence_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Competence entity.
     *
     * @Route("/{id}", name="competence_update")
     * @Method("PUT")
     * @Template("EltonLessonBundle:Competence:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonLessonBundle:Competence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Competence entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('competence_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Competence entity.
     *
     * @Route("/{id}", name="competence_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EltonLessonBundle:Competence')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Competence entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('competence'));
    }

    /**
     * Creates a form to delete a Competence entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('competence_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
