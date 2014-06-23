<?php

namespace Elton\TeacherBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Elton\TeacherBundle\Entity\Teacher;
use Elton\TeacherBundle\Form\RegistrationFormType;
use Elton\CoreBundle\Form\IntegerType;
use Elton\CoreBundle\Form\StringType;
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
     * Index of teachers
     * 
     * @Route("/", name="teacher_index")
     * @Method("GET")
     * @Template()
     */
    public function indexTeacherAction()
    {
        $user = $this->get('security.context')->getUser()->getToken();

        return array(
            'user' => $user,
        );
    }
    
    /**
     * Lists all Teacher entities.
     *
     * @Route("/", name="teacher")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository('EltonTeacherBundle:Teacher')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * Find teacher by postal code
     * 
     * @Route("/findByPostalCode/{region}", name="teacher_by_region")
     * @Method("GET")
     * @Template()
     */
    public function regionAction($region)
    {
        $teachers = $this->get('elton.teacher.manager')->findTeacherByRegion($region);
        
        return array('teachers' => $teachers, 'region' => $region);
    }
    
    /**
     * Show teacher by their division level
     * 
     * @Route("/findByClassLevel/{level}", name="teacher_by_level")
     * @Method("GET")
     * @Template()
     */
    public function levelAction($level)
    {
        $teachers = $this->get('elton.teacher.manager')->getRepository()->getTeacherByLevel($level);
        $level = $this->get('elton.level.manager')->getRepository()->findById($level);
        
        return array('teachers' => $teachers, 'level' => $level[0]);
    }
    
    /**
     * Creates a new Teacher entity.
     *
     * @Route("/", name="teacher_create")
     * @Method("POST")
     * @Template("EltonTeacherBundle:Teacher:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Teacher();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('teacher_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Teacher entity.
    *
    * @param Teacher $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Teacher $entity)
    {
        $form = $this->createForm(new RegistrationFormType(), $entity, array(
            'action' => $this->generateUrl('teacher_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));
        
        return $form;
    }
    
    /**
     * To search teacher by Id
     * 
     * @Route("/byId", name="teacher_by_id")
     * @Template()
     */
    public function searchTeacherByIdAction()
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
                    if($teacher == null)
                    {
                        throw new \Doctrine\ORM\NoResultException();
                    }
                }
                catch(\Doctrine\ORM\NoResultException $ex)
                {
                    return $this->render('EltonCoreBundle:Error:BackOffice/notFound.html.twig');
                }
                $deleteForm = $this->createDeleteForm($teacherId);
                
                return $this->render('EltonTeacherBundle:Teacher:show.html.twig', array(
                    'entity' => $teacher,
                    'delete_form' => $deleteForm->createView()));
            }
        }
        
        return $this->render('EltonCoreBundle:Core:id.html.twig', array('form' => $form->createView()));
    }
    
    /**
     * To search teacher by UserName
     * 
     * @Route("/byUsername", name="teacher_by_username")
     * @Template()
     */
    public function searchTeacherByUsernameAction()
    {
        $form = $this->createForm(new StringType());
        $request = $this->get('request');

        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if($form->isValid())
            {
                $teacherUserName = $form->get('user')->getData();
                try
                {
                    $teacher = $this->get('elton.teacher.manager')->getRepository()->getTeacherByUserName($teacherUserName);
                }
                catch(\Doctrine\ORM\NoResultException $ex)
                {
                    return $this->render('EltonCoreBundle:Error:BackOffice/notFound.html.twig');
                }
                try
                {
                    $deleteForm = $this->createDeleteForm($teacher->getId());
                } 
                catch (\Symfony\Component\DependencyInjection\Exception\OutOfBoundsException $ex) 
                {
                    return $this->render('EltonCoreBundle:Error:BackOffice/notFound.html.twig');
                }
                
                return $this->render('EltonTeacherBundle:Teacher:show.html.twig', array(
                    'entity' => $teacher,
                    'delete_form' => $deleteForm->createView()));
            }
        }
        
        return $this->render('EltonCoreBundle:Core:id.html.twig', array('form' => $form->createView()));
    }

    /**
     * Displays a form to create a new Teacher entity.
     *
     * @Route("/new", name="teacher_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Teacher();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Teacher entity.
     *
     * @Route("/show/{id}", name="teacher_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EltonTeacherBundle:Teacher')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Teacher.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Teacher entity.
     *
     * @Route("/{id}/edit", name="teacher_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonTeacherBundle:Teacher')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Teacher entity.');
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
    * Creates a form to edit a Teacher entity.
    *
    * @param Teacher $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Teacher $entity)
    {
        $form = $this->createForm(new RegistrationFormType(), $entity, array(
            'action' => $this->generateUrl('teacher_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Mettre à jour'));

        return $form;
    }
    /**
     * Edits an existing Teacher entity.
     *
     * @Route("/{id}", name="teacher_update")
     * @Method("PUT")
     * @Template("EltonTeacherBundle:Teacher:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonTeacherBundle:Teacher')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Teacher entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('teacher_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Teacher entity.
     *
     * @Route("/{id}", name="teacher_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EltonTeacherBundle:Teacher')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Teacher entity.');
            }
            
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('teacher'));
    }

    /**
     * Creates a form to delete a Teacher entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('teacher_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer'))
            ->getForm()
        ;
    }
    
    /**
     * Create a division for the teacher
     * 
     * @Route("/create/division", name="teacher_create_division")
     */
    public function createDivisionAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
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
        $user = $this->get('security.context')->getToken()->getUser();
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
        if($request->getMethod() == "DELETE")
        {
            var_dump("JAMBON POUR TOUS"); exit;
        }
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
        $user = $this->get('security.context')->getToken()->getUser();
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
        $user = $this->get('security.context')->getToken()->getUser();
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
