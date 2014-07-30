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
            ->add('name')
            ->add('description')
            ->add('file', 'sonata_type_model', array('label' => 'Photo de l\'activité'))
            ->add('files', 'sonata_type_model', array('label' => 'Fichiers de l\'activité', 'by_reference' => false,'multiple' => true,))
            ->add('type', 'choice', array('label' => 'Type d\'activité' ,'choices' => \Elton\CoreBundle\ORM\ActivityEnumType::get_enum_values()))
                ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')->add('files')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')->add('files')->add('description')->add('file')
        ;
    }
}