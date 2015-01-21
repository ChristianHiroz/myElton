<?php

namespace Elton\CoreBundle\Controller;

use Elton\CoreBundle\Entity\Jumbotron;
use Elton\CoreBundle\Form\JumbotronType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Elton\TeacherBundle\Entity\Flyer;
use Elton\TeacherBundle\Form\FlyerFormType;

/**
 * BackOffice controller.
 *
 */
class BackOfficeController extends Controller
{
    /**
     * Creates a form to edit a Jumbotron entity.
     *
     * @param Jumbotron $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Jumbotron $entity)
    {
        $form = $this->createForm(new JumbotronType(), $entity, array(
            'action' => $this->generateUrl('jumbotron_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier'));

        return $form;
    }

    /**
     * Edits an existing Jumbotron entity.
     *
     * @Route("/admin/backoffice/editJumbotron", name="jumbotron_update")
     * @Template("EltonCoreBundle:BackOffice:jumbotron_edit.html.twig")
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EltonCoreBundle:Jumbotron')->find(1);

        if (!$entity) {
            $entity = new Jumbotron();
            $em->persist($entity);
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl("sonata_admin_dashboard"));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
    
    /**
     * @Route("/admin/backoffice/inactifList", name="teacher_inactif_list")
     * @Template("EltonCoreBundle:BackOffice:teacher_inactif_list.html.twig")
     */
    public function showInactifTeacherAction()
    {
        $list = $this->get('elton.teacher.manager')->getRepository()->getInactifTeacher();
        
        return array(
            'teachers' => $list,
            'send' => false,
        );
    }
    
    /**
     * @Route("/admin/backoffice/payingList", name="teacher_paying_list")
     * @Template("EltonCoreBundle:BackOffice:teacher_paying_list.html.twig")
     */
    public function showPayingTeacherAction()
    {
        $list = $this->get('elton.teacher.manager')->getRepository()->getPayingTeacher();
        
        return array(
            'teachers' => $list,
            'send' => false,
        );
    }
    
    /**
     * @Route("/admin/backoffice/sendexpiration/{id}", name="admin_send_expiration")
     * @Template("EltonCoreBundle:BackOffice:teacher_inactif_list.html.twig")
     */
    public function sendExpirationAction($id)
    {
        $list = $this->get('elton.teacher.manager')->getRepository()->getInactifTeacher();
        $teacher = $this->get('elton.teacher.manager')->getRepository()->find($id);
        $this->get('elton.mailer')->sendTestEnd($teacher, true);
        
        return array(
            'teachers' => $list,
            'send' => true,
        );
    }
    
    /**
     * @Route("/admin/backoffice/sendpayment/{id}", name="admin_send_payment")
     * @Template("EltonCoreBundle:BackOffice:teacher_paying_list.html.twig")
     */
    public function sendPaymentAction($id)
    {
        $list = $this->get('elton.teacher.manager')->getRepository()->getPayingTeacher();
        
        $teacher = $this->get('elton.teacher.manager')->getRepository()->find($id);
        $this->get('elton.mailer')->sendPaymentRequest($teacher, false);
        
        return array(
            'teachers' => $list,
            'send' => true,
        );
    }
    
    /**
     * @Route("admin/backoffice/flyer/create", name="admin_flyer_create")
     * @Template("EltonCoreBundle:BackOffice:flyer_create.html.twig")
     */
    public function flyerCreateAction(Request $request)
    {
        $entity = new Flyer();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            if($entity->getSubscriptions()->getIsPaymentValid()){
                $entity->getSubscriptions()->setPaymentDate(new \DateTime());
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->container->get('elton.mailer')->sendRegisterEnd($entity);

            return $this->redirect($this->generateUrl('sonata_admin_dashboard'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    private function createCreateForm(Flyer $entity)
    {
        $form = $this->createForm(new FlyerFormType(), $entity, array(
            'action' => $this->generateUrl('admin_flyer_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));

        return $form;
    }

}
