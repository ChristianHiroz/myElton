<?php

namespace Elton\TeacherBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use Elton\PaymentBundle\Form\SubscriptionFormType;

class FlyerFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $builder
            ->add('civilite', 'choice', array('label' => 'Civilité', "attr" => array("class" => "form-control"), 'choices' => array("M." => 'M.', "Mme." => 'Mme.')))
            ->add('name', 'text', array('label' => 'Nom', 'attr' => array('placeholder' => 'Entrez le nom que vos élèves verront')))
            ->add('firstName', 'text', array('label' => 'Prénom', 'attr' => array('placeholder' => 'Entrez votre prénom')))
            ->add('postalCode', 'text', array('label' => 'Code postal', 'attr' => array('placeholder' => 'Entrez le code postal de votre école')))
            ->add('email', 'email', array('label' => 'Adresse email', 'attr'=> array('placeholder' => 'Entrez votre adresse email')))
            ->add('school', 'text', array('label' => 'École', 'attr' => array('placeholder' => 'Entrez le nom de votre école')))
            ->add('address', 'text', array('label' => 'Adresse', 'attr' => array('placeholder' => 'Entrez l\'adresse de votre école')))
            ->add('town', 'text', array('label' => 'Ville', 'attr' => array('placeholder' => 'Entrez la ville de votre école')))
            ->add('subscriptions', new SubscriptionFormType())
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elton\TeacherBundle\Entity\Flyer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elton_flyer_registration';
    }
}
