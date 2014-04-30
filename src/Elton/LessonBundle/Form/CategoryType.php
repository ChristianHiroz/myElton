<?php

namespace Elton\LessonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('level', 'entity', array("class" => "Elton\CoreBundle\Entity\Level",
                                           "property" => "libelle"))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elton\LessonBundle\Entity\Category'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elton_lessonbundle_category';
    }
}
