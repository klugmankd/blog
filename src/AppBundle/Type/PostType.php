<?php

namespace AppBundle\Type;


use AppBundle\Controller\PostController;
use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', TextType::class, array(
                    'attr'  => array('class' => 'field animation'),
                    'label_attr' => array('class' => 'label')
            ))
            ->add('description', TextareaType::class, array(
                'attr'  => array('class' => 'field animation'),
                'label_attr' => array('class' => 'label')
            ))
            ->add('content', TextareaType::class, array(
                'attr'  => array('class' => 'field animation'),
                'label_attr' => array('class' => 'label')
            ))
            ->add('category', EntityType::class, array(
                'class' => 'AppBundle:Category',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
                'attr'  => array('class' => 'field animation'),
                'label_attr' => array('class' => 'label'),
                'choice_label' => 'name'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Post::class,
        ));
    }
}