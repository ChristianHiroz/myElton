<?php

namespace Elton\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Elton\CoreBundle\Entity\File;
use Elton\CoreBundle\Form\FileType;
use Elton\CoreBundle\Form\ExtensionType;

/**
 * File controller.
 *
 * @Route("/file")
 */
class FileController extends Controller
{

    /**
     * Lists all File entities.
     *
     * @Route("/", name="file")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EltonCoreBundle:File')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * Lists all File entities with this extension (param)
     * 
     * @Route("/filesWithExtension", name="file_by_extension")
     */
    public function fileByExtensionAction()
    {
        $form = $this->createForm(new ExtensionType());
        $request = $this->get('request');

        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if($form->isValid())
            {
                $extension = $form->get('extension')->getData();
                try
                {
                    $files = $this->get('elton.file.manager')->getRepository()->getFilesByExtension($extension);
                    if($files == null)
                    {
                        throw new \Doctrine\ORM\NoResultException();
                    }
                }
                catch(\Doctrine\ORM\NoResultException $ex)
                {
                    return $this->render('EltonCoreBundle:Error:BackOffice/notFound.html.twig');
                }
                
                return $this->render('EltonCoreBundle:File:index.html.twig', array(
                    'entities' => $files));
            }
        }
        
        return $this->render('EltonCoreBundle:Core:id.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * Creates a new File entity.
     *
     * @Route("/", name="file_create")
     * @Method("POST")
     * @Template("EltonCoreBundle:File:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new File();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('file_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a File entity.
    *
    * @param File $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(File $entity)
    {
        $form = $this->createForm(new FileType(), $entity, array(
            'action' => $this->generateUrl('file_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new File entity.
     *
     * @Route("/new", name="file_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new File();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a File entity.
     *
     * @Route("/{id}", name="file_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonCoreBundle:File')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing File entity.
     *
     * @Route("/{id}/edit", name="file_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonCoreBundle:File')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
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
    * Creates a form to edit a File entity.
    *
    * @param File $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(File $entity)
    {
        $form = $this->createForm(new FileType(), $entity, array(
            'action' => $this->generateUrl('file_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier'));

        return $form;
    }
    /**
     * Edits an existing File entity.
     *
     * @Route("/{id}", name="file_update")
     * @Method("PUT")
     * @Template("EltonCoreBundle:File:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonCoreBundle:File')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find File entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('file_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a File entity.
     *
     * @Route("/{id}", name="file_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EltonCoreBundle:File')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find File entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('file'));
    }

    /**
     * Creates a form to delete a File entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('file_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
        ;
    }
}
