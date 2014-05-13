<?php

namespace Elton\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class LessonAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('libelle')
            ->add('files', 'sonata_type_model', array('label' => 'Niveau de la classe', 'associated_property' => 'libelle'))
            ->add('competances', 'sonata_type_collection', array('label' => 'Compétances de l\'activité', 'type_options' => array('delete' => false)))
            ->add('level', 'sonata_type_model', array('label' => 'Niveau de l\'activité', 'associated_property' => 'libelle'))
            ->add('category', 'sonata_type_model', array('label' => 'Niveau de la classe', 'associated_property' => 'libelle'))
            ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('libelle')->add('competances')->add('level')->add('category')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('libelle')->add('competances')->add('level')->add('category')->add('files')
        ;
    }
}