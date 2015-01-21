<?php

namespace Elton\CoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Elton\TeacherBundle\Form\RegistrationFormType;

class TeacherAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('civilite', 'choice', array('label' => 'Civilité', 'choices' => array("M." => 'M.', "Mme." => 'Mme.')))
            ->add('username', 'text', array('label' => 'Nom d\'utilisateur', 'attr'=> array('placeholder' => 'Entrez votre nom d\'utilisateur')))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Mot de passe', 'attr'=> array('placeholder' => 'Entrez votre mot de passe')),
                'second_options' => array('label' => 'Confirmation du mot de passe', 'attr'=> array('placeholder' => 'Confirmez votre mot de passe')),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('name', 'text', array('label' => 'Nom', 'attr' => array('placeholder' => 'Entrez le nom que vos élèves verront')))
            ->add('school', 'text', array('label' => 'Ecole', 'attr' => array('placeholder' => 'Entrez le nom de votre école')))
            ->add('address', 'text', array('label' => 'Adresse', 'attr' => array('placeholder' => 'Entrez l\'adresse de votre école')))
            ->add('town', 'text', array('label' => 'Ville', 'attr' => array('placeholder' => 'Entrez le nom de la ville de votre école')))
            ->add('firstName', 'text', array('label' => 'Prénom', 'attr' => array('placeholder' => 'Entrez votre prénom')))
            ->add('postalCode', 'text', array('label' => 'Code postal', 'attr' => array('placeholder' => 'Entrez le code postal de votre école')))
            ->add('email', 'email', array('label' => 'Adresse email', 'attr'=> array('placeholder' => 'Entrez votre adresse email')))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')->add('name')->add('firstName')->add('postalCode')->add('email')->add('roles')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')->addIdentifier('username')->addIdentifier('name')->add('firstName')->add('postalCode')->add('email')->add('roles')
        ;
    }
}
