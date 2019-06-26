<?php

namespace adminBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class found_itemesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
                ->add('photo',FileType::class)
                ->add('foundOn',DateType::class)
                ->add('foundArea')
                ->add('otherInfo',TextareaType::class)
                ->add('contactInfo')
                ->add('category',EntityType::class,array(
                        'required'=>true,
                        'placeholder'=>'Select category',
                        'class'=>'adminBundle\Entity\category_itemes',
                        'query_builder'=>function (EntityRepository $er){
                            return  $er->createQueryBuilder('u');
                        },
                'choice_label' => 'heading',
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'adminBundle\Entity\found_itemes'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'adminbundle_found_itemes';
    }


}
