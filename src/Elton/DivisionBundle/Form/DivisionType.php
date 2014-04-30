<?php

namespace Elton\DivisionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DivisionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', 'text', array('label' => 'Nom'))
            ->add('username', 'text', array('label' => 'Identifiant'))
            ->add('password', 'password', array('label' => 'Mot de passe'))
            ->add('teacher', 'entity', array('class' => 'EltonTeacherBundle:Teacher', 'property' => 'name',
                                           'label' => 'Professeur'))
            ->add('level', 'entity', array('class' => 'EltonCoreBundle:Level', 'property' => 'libelle',
                                           'label' => 'Niveau'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elton\DivisionBundle\Entity\Division'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elton_divisionbundle_division';
    }
}
