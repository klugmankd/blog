<?php

namespace AppBundle\Type;

use AppBundle\Entity\User;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('firstName', TextType::class, array(
                'attr'  => array('class' => 'field animation'),
                'label_attr' => array('class' => 'label')
            ))
            ->add('lastName', TextType::class, array(
                'attr'  => array('class' => 'field animation'),
                'label_attr' => array('class' => 'label')
            ))
            ->add('username', TextType::class,array(
                'attr'  => array('class' => 'field animation'),
                'label_attr' => array('class' => 'label')
            ))
            ->add('email', TextType::class,array(
                'attr'  => array('class' => 'field animation'),
                'label_attr' => array('class' => 'label')
            ))
            ->add('password', PasswordType::class,array(
                'attr'  => array('class' => 'field animation'),
                'label_attr' => array('class' => 'label')
            ))
            ->add('birthday', DateType::class,array(
                'attr'  => array('class' => 'field animation'),
                'label_attr' => array('class' => 'label')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}