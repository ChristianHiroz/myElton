<?php

namespace Elton\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Elton\CoreBundle\ORM\LessonEnumType;

class LessonAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('libelle')
            ->add('description', 'textarea')
            ->add('file', 'sonata_type_model', array('label' => 'Document de la leçon'))
            ->add('category', 'sonata_type_model', array('label' => 'Catégorie de la lesson'))
            ->add('activitys', 'sonata_type_model', array('label' => 'Activités de la leçon', 'by_reference' => false,'multiple' => true, 'required' => false))
            ->add('competences', 'sonata_type_model', array('label' => 'Compétences de l\'activité', 'by_reference' => true,'multiple' => true,))
            ->add('type', 'choice', array('label'=> 'type', 'choices' => LessonEnumType::get_enum_values()))
            ->add('active', 'choice', array('label' => 'Actif', 'choices' => array(0 => 'Oui', 1 => 'Non')))
                ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('libelle')->add('activitys')->add('category')->add('type')->add('competences')->add('active')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('libelle')->add('activitys')->add('category')->add('type')->add('competences')->add('active')
        ;
    }
}