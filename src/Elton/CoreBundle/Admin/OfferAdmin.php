<?php

namespace Elton\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class OfferAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array('label' => 'Nom de l\'offre'))  
            ->add('price', 'number', array('label' => 'Prix de l\'offre'))
            ->add('startAt', 'date', array('label' => 'Date de début'))            
            ->add('endAt', 'date', array('label' => 'Date de fin'))
            ->add('description', 'textarea', array('label' => 'Description de l\'offre'))
            ->add('isActive', 'choice', array('label' => 'Actif', 'choices' => array(1 => 'Oui', 0 => 'Non')))               
            ->add('isEnCours', 'choice', array('label' => 'En cours', 'choices' => array(1 => 'Oui', 0 => 'Non')))

        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')->add('isActive')->add('isEnCours')->add('name')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')->addIdentifier('isActive')->addIdentifier('isEnCours')->addIdentifier('name')
        ;
    }
}