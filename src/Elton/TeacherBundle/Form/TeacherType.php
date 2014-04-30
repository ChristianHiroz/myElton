<?php

namespace Elton\TeacherBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TeacherType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('label' => 'Nom d\'utilisateur', 'attr'=> array('placeholder' => 'Entrez votre nom d\'utilisateur')))
            ->add('name', 'text', array('label' => 'Nom', 'attr' => array('placeholder' => 'Entrez le nom que vos élèves verront')))
            ->add('firstName', 'text', array('label' => 'Prénom', 'attr' => array('placeholder' => 'Entrez votre prénom')))
            ->add('postalCode', 'text', array('label' => 'Code postal', 'attr' => array('placeholder' => 'Entrez le code postal de votre école')))
            ->add('email', 'email', array('label' => 'Adresse email', 'attr'=> array('placeholder' => 'Entrez votre adresse email')))
            ->add('password', 'password', array('label' => 'Mot de passe', 'attr'=> array('placeholder' => 'Entrez votre mot de passe')))
        ;
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
        return 'elton_teacherbundle_teacher';
    }
}
