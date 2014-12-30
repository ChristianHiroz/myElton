<?php

namespace Elton\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PCodeAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('code', 'text', array('label' => 'Code promotionnel'))                 
            ->add('postalCode', 'text', array('label' => 'Code postal (75001, 7500X, 750XX, 75XXX)'))
            ->add('offer', 'sonata_type_model', array('label' => 'Offre associée'))

        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')->add('code')->add('postalCode')->add('offer')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')->addIdentifier('code')->addIdentifier('postalCode')->addIdentifier('offer')
        ;
    }
}