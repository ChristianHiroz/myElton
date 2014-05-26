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
            ->add('files', 'sonata_type_model', array('label' => 'Fichiers','by_reference' => false,'multiple' => true,))
            ->add('competances', 'sonata_type_model', array('label' => 'Compétances de l\'activité', 'by_reference' => false,'multiple' => true,))
            ->add('level', 'sonata_type_model', array('label' => 'Niveau de l\'activité'))
            ->add('category', 'sonata_type_model', array('label' => 'Niveau de la classe'))
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
            ->add('libelle')->add('competances')->add('level')->add('category')
        ;
    }
}