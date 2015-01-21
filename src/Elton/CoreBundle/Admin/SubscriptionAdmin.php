<?php

namespace Elton\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SubscriptionAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('teacher', 'sonata_type_model', array('label' => 'Prof'))
            ->add('offer', 'sonata_type_model', array('label' => 'Offre'))
            ->add('isPaymentValid', 'choice', array('label' => 'Valide', 'choices' => array(1 => 'Oui', 0 => 'Non')))
            ->add('subscriptionDate', 'date', array('label' => 'Date de création'))
            ->add('paymentDate', 'date', array('label' => 'Date de paiement'))
            ->add('paymentType', 'choice', array('label' => 'Type de paiement', 'choices' => array('CB' => 'CB', 'CH' => 'CH', 'LIQ' => 'LIQ')))
            ->add('orderId', 'text', array('label' => 'Num commande'))
                ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('teacher')->add('offer')->add('isPaymentValid')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('teacher')->addIdentifier('offer')->addIdentifier('isPaymentValid')->addIdentifier('orderId')
        ;
    }
}