<?php

namespace Elton\LessonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryLibelleType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', 'entity', array('class' => 'EltonLessonBundle:Category', 
                                           'property' => 'libelle',
                                           'label' => 'Catégorie'))
            ->add('Envoyer', 'submit')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elton_lessonbundle_lesson';
    }
}
