<?php

namespace Elton\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class FileAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('file', 'file', array('label' => 'Fichier', 'required' => false))
            ->add('ogg', 'sonata_type_model', array('label' => 'Ogg', 'property' => 'alt', 'required' => false))
            ->add('lien', 'text', array('label' => 'Lien', 'required' => false))
            ->add('level', 'sonata_type_model')
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('url')->add('alt')->add('id')->add('ogg')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('url')->addIdentifier('alt')->addIdentifier('id')->add('ogg')
        ;
    }
}