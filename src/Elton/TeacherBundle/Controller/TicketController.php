<?php

namespace Elton\TeacherBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Elton\TeacherBundle\Entity\Ticket;
use Elton\TeacherBundle\Form\TicketType;

/**
 * Ticket controller.
 *
 * @Route("/ticket")
 */
class TicketController extends Controller
{
    /**
     * Creates a new Ticket entity.
     *
     * @Route("/", name="ticket_create")
     * @Method("POST")
     * @Template("EltonTeacherBundle:Ticket:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        $entity = new Ticket();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $this->get('security.context')->getToken()->getUser();
            $entity->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('accueil'));
        }
        
        $returnArray['entity'] = $entity; $returnArray['form'] = $form->createView();
        
        return $returnArray;
    }

    /**
     * Creates a form to create a Ticket entity.
     *
     * @param Ticket $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Ticket $entity)
    {
        $form = $this->createForm(new TicketType(), $entity, array(
            'action' => $this->generateUrl('ticket_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Envoyer'));

        return $form;
    }

    /**
     * Displays a form to create a new Ticket entity.
     *
     * @Route("/new", name="ticket_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $returnArray = $this->get('elton.teacher.manager')->check();
        $entity = new Ticket();
        $form   = $this->createCreateForm($entity);

        $returnArray['entity'] = $entity; $returnArray['form'] = $form->createView();
        
        return $returnArray;
    }
}
