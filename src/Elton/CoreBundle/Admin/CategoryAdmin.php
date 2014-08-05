<?php

namespace Elton\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Elton\CoreBundle\ORM\ColorEnumType;

class CategoryAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('libelle', 'text', array('label' => 'Nom de la catégorie'))
            ->add('level', 'sonata_type_model', array('label' => 'Niveau de la catégorie', 'property' => 'libelle'))
            ->add('color', 'choice', array('label' => 'Couleur du bouton','choices' => ColorEnumType::get_enum_values()))
            ->add('active', 'choice', array('label' => 'Actif', 'choices' => array(0 => 'Oui', 1 => 'Non')))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('libelle')
            ->add('level')
            ->add('color')
            ->add('active')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('libelle')
            ->addIdentifier('level')
            ->add('color')
            ->add('active')
        ;
    }
}