<?php

namespace Elton\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class DivisionAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('libelle', 'text', array('label' => 'Nom de la classe'))
            ->add('username', 'text', array('label' => 'Identifiant'))
            ->add('password', 'password', array('label' => 'Mot de passe'))
            ->add('teacher', 'sonata_type_model', array('label' => 'Professeur de la classe'))
            ->add('level', 'sonata_type_model', array('label' => 'Niveau de la classe'))
            ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('libelle')->add('username')->add('teacher')->add('level')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('libelle')->add('username')->add('teacher')->add('level')
        ;
    }
}