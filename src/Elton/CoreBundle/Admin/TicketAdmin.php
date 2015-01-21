<?php

namespace Elton\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TicketAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('reason', 'sonata_type_model', array('label' => 'Raison'))
            ->add('description', 'textarea', array('label' => 'Description du ticket'))
            ->add('user', 'sonata_type_model', array('label' => 'Utilisateur'))
            ->add('isSolved', 'choice', array('label' => 'Résolu', 'choices' => array(1 => 'Oui', 0 => 'Non')))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('isSolved')->add('reason')->add('user')->add('lastUpdate')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('reason')
            ->addIdentifier('user')
            ->addIdentifier('lastUpdate')
            ->addIdentifier('isSolved')
        ;
    }
}