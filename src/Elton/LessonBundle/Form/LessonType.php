<?php

namespace Elton\LessonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LessonType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('files', 'entity', array('class' => 'EltonCoreBundle:File',
                                          'property' => 'id',
                                          'label' => 'Fichiers',
                                          'expanded' => false,
                                          'multiple' => true))
            ->add('competences', 'entity', array('class' => 'EltonLessonBundle:Competence', 
                                                 'property' => 'libelle',
                                                 'label' => 'Compétences',
                                                 'expanded' => false,
                                                 'multiple' => true))
            ->add('level', 'entity', array('class' => 'EltonCoreBundle:Level', 
                                           'property' => 'libelle',
                                           'label' => 'Niveau'))
            ->add('category', 'entity', array('class' => 'EltonLessonBundle:Category', 
                                           'property' => 'libelle',
                                           'label' => 'Catégorie'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Elton\LessonBundle\Entity\Lesson'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'elton_lessonbundle_lesson';
    }
}
