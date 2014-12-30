<?php

namespace Elton\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ActivityAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('description')
            ->add('file', 'sonata_type_model', array('label' => 'Photo de l\'activité'))
            ->add('files', 'sonata_type_model', array('label' => 'Fichiers de l\'activité'))
            ->add('type', 'choice', array('label' => 'Type d\'activité' ,'choices' => \Elton\CoreBundle\ORM\ActivityEnumType::get_enum_values()))
            ->add('active', 'choice', array('label' => 'Actif', 'choices' => array(1 => 'Oui', 0 => 'Non')))
            ->add('level', 'sonata_type_model', array('label' => 'Niveau de l\'activité'))
            ->add('category', 'sonata_type_model', array('label' => 'Catégorie de l\'activité'))
                ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')->add('files')->add('active')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')->add('files')->add('description')->add('file')->add('active')
        ;
    }
}