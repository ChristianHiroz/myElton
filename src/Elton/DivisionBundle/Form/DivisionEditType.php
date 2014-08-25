<?php

namespace Elton\DivisionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class DivisionEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {  
        parent::buildForm($builder, $options);
        $builder
            ->add('libelle', 'text', array('label' => 'Nom'))
            ->add('username', 'text', array('label' => 'Nom d\'utilisateur', 'attr'=> array('placeholder' => 'Entrez votre nom d\'utilisateur')))
            ->add('level', 'entity', array('class' => 'EltonCoreBundle:Level','property' => 'libelle',
                                           'query_builder' => function(EntityRepository $er) {
                                                                                                 return $er->createQueryBuilder('Level')->select('l')->from('EltonCoreBundle:Level', 'l')->where('l.libelle IN (:lapin)')->setParameter('lapin', array('CP', 'CE', 'CM'));
                                                                                             }, 
                                           
                                           'label' => 'Niveau'))
            ->add('submit', 'submit', array('label' => 'Modifier votre classe'))
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
