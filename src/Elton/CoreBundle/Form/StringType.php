<?php

namespace Elton\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class StringType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', 'text', array('label' => '', 'attr'=> array('placeholder' => 'Entrez le nom')))
            ->add('Envoyer', 'submit')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elton_corebundle_stringType';
    }
}
