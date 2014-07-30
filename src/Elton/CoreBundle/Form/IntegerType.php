<?php

namespace Elton\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class IntegerType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', 'integer', array('label' => '', 'attr'=> array('placeholder' => 'Entrez l\'id')))
            ->add('Envoyer', 'submit')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elton_corebundle_integerType';
    }
}
