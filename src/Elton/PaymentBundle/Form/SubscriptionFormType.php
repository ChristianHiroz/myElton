<?php

namespace Elton\PaymentBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;

class SubscriptionFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('offer', 'entity', array('class' => 'EltonPaymentBundle:Offer','property' => 'name', "attr" => array("class" => "form-control")))
                ->add('track', 'entity', array('class' => 'EltonPaymentBundle:Tracking','property' => 'name', "attr" => array("class" => "form-control")))
                ->add('isPaymentValid', 'choice', array('label' => 'Validité', 'choices' => array(1 => 'Oui', 0 => 'Non'), "attr" => array("class" => "form-control")))
                ->add('paymentType',  'choice', array('label' => 'Type', 'choices' => array('CB' => 'CB', 'CH' => 'CH', 'LIQ' => 'LIQ'), "attr" => array("class" => "form-control")))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elton\PaymentBundle\Entity\Subscription'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elton_subscription';
    }
}
