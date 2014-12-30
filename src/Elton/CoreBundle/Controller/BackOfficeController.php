<?php

namespace Elton\CoreBundle\Controller;

use Elton\CoreBundle\Entity\Jumbotron;
use Elton\CoreBundle\Form\JumbotronType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
}
