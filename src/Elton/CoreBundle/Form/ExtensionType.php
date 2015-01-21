<?php

namespace Elton\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ExtensionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('extension', 'text', array('label' => '', 'attr'=> array('placeholder' => 'Entrez une extension (jpg, png)')))
            ->add('Envoyer', 'submit')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elton_corebundle_extensionType';
    }
}
