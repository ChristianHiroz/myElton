<?php

namespace Elton\LessonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Elton\LessonBundle\Entity\Lesson;
use Elton\LessonBundle\Form\LessonType;
use Elton\CoreBundle\Form\IntegerType;
use Elton\LessonBundle\Form\CategoryLibelleType;

/**
 * Lesson controller.
 *
 * @Route("/lesson")
 */
class LessonController extends Controller
{

    /**
     * Lists all Lesson entities.
     *
     * @Route("/", name="lesson")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EltonLessonBundle:Lesson')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * To search lesson by Id
     * 
     * @Route("/byId", name="lesson_by_id")
     * @Template()
     */
    public function searchLessonByIdAction()
    {
        $form = $this->createForm(new IntegerType());
        $request = $this->get('request');

        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if($form->isValid())
            {
                $lessonId = $form->get('id')->getData();
                try
                {
                    $lesson = $this->get('elton.lesson.manager')->getRepository()->find($lessonId);
                    if($lesson == null)
                    {
                        throw new \Doctrine\ORM\NoResultException();
                    }
                }
                catch(\Doctrine\ORM\NoResultException $ex)
                {
                    return $this->render('EltonCoreBundle:Error:BackOffice/notFound.html.twig');
                }
                $deleteForm = $this->createDeleteForm($lessonId);
                return $this->render('EltonLessonBundle:Lesson:show.html.twig', array('entity' => $lesson, 'delete_form' => $deleteForm->createView()));
                
            }
        }
        
        return $this->render('EltonCoreBundle:Core:id.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * Show lessons by their category
     * 
     * @Route("/findByCategory", name="lesson_by_category")
     */
    public function findByCategoryAction()
    {
        $form = $this->createForm(new CategoryLibelleType());
        $request = $this->get('request');

        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if($form->isValid())
            {
                $category = $form->get('category')->getData();
                try
                {
                    $lessons = $this->get('elton.lesson.manager')->getRepository()->getLessonByCategory($category);
                    if($lessons == null)
                    {
                        throw new \Doctrine\ORM\NoResultException();
                    }
                }
                catch(\Doctrine\ORM\NoResultException $ex)
                {
                    return $this->render('EltonCoreBundle:Error:BackOffice/notFound.html.twig');
                }
                return $this->render('EltonLessonBundle:Lesson:category.html.twig', array('lessons' => $lessons, 'category' => $category));
            }
        }
        
        return $this->render('EltonCoreBundle:Core:id.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * Show lessons by their level
     * 
     * @Route("/findByLevel/{level}", name="lesson_by_level")
     * @Method("GET")
     * @Template()
     */
    public function levelAction($level)
    {
        $lessons = $this->get('elton.lesson.manager')->getRepository()->getLessonByLevel($level);
        $level = $this->get('elton.level.manager')->getRepository()->findById($level);
        
        return array('lessons' => $lessons, 'level' => $level[0]);
    }
    
    /**
     * Creates a new Lesson entity.
     *
     * @Route("/", name="lesson_create")
     * @Method("POST")
     * @Template("EltonLessonBundle:Lesson:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Lesson();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lesson_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Lesson entity.
    *
    * @param Lesson $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Lesson $entity)
    {
        $form = $this->createForm(new LessonType(), $entity, array(
            'action' => $this->generateUrl('lesson_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

    /**
     * Displays a form to create a new Lesson entity.
     *
     * @Route("/new", name="lesson_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Lesson();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Lesson entity.
     *
     * @Route("/{id}", name="lesson_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonLessonBundle:Lesson')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lesson entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Lesson entity.
     *
     * @Route("/{id}/edit", name="lesson_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonLessonBundle:Lesson')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lesson entity.');
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
    * Creates a form to edit a Lesson entity.
    *
    * @param Lesson $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Lesson $entity)
    {
        $form = $this->createForm(new LessonType(), $entity, array(
            'action' => $this->generateUrl('lesson_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier'));

        return $form;
    }
    /**
     * Edits an existing Lesson entity.
     *
     * @Route("/{id}", name="lesson_update")
     * @Method("PUT")
     * @Template("EltonLessonBundle:Lesson:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonLessonBundle:Lesson')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lesson entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('lesson_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Lesson entity.
     *
     * @Route("/{id}", name="lesson_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EltonLessonBundle:Lesson')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Lesson entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('lesson'));
    }

    /**
     * Creates a form to delete a Lesson entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('lesson_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
        ;
    }
    
}
