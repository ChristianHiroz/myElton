<?php

namespace Elton\TeacherBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function getArrayForm()
    {
        $builder = array();
        return $builder
            ->add('username', 'text', array('label' => 'Nom d\'utilisateur', 'attr'=> array('placeholder' => 'Entrez votre nom d\'utilisateur')))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Mot de passe', 'attr'=> array('placeholder' => 'Entrez votre mot de passe')),
                'second_options' => array('label' => 'Confirmation du mot de passe', 'attr'=> array('placeholder' => 'Confirmez votre mot de passe')),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('name', 'text', array('label' => 'Nom', 'attr' => array('placeholder' => 'Entrez le nom que vos élèves verront')))
            ->add('firstName', 'text', array('label' => 'Prénom', 'attr' => array('placeholder' => 'Entrez votre prénom')))
            ->add('postalCode', 'text', array('label' => 'Code postal', 'attr' => array('placeholder' => 'Entrez le code postal de votre école')))
            ->add('email', 'email', array('label' => 'Adresse email', 'attr'=> array('placeholder' => 'Entrez votre adresse email')))
        ;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder = getArrayForm();
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elton\TeacherBundle\Entity\Teacher'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elton_teacher_registration';
    }
}
