<?php

namespace Elton\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JumbotronType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active', 'choice', array('label' => 'Actif', 'choices' => array(1 => 'Oui', 0 => 'Non')))
            ->add('title', 'text', array('label' => 'Titre'))
            ->add('message', 'textarea', array('label' => 'Message'))
            ->add('messageWelcome', 'textarea', array('label' => 'Message de bienvenue du site'))
            ->add('link', 'text', array('label' => 'Lien'))
            ->add('temp', 'textarea', array('label' => 'HTMP page temp', 'required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elton\CoreBundle\Entity\Jumbotron'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elton_corebundle_jumbotron';
    }
}
