<?php
// src/AppBundle/Form/RegistrationType.php
namespace adminBundle\Form;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category',EntityType::class,array(
                'required'=>true,
                'placeholder'=>'Select a Category for this User',
                'class'=>'adminBundle\Entity\categorie_user',
                'query_builder'=>function (EntityRepository $er){
                    return  $er->createQueryBuilder('u');
                },
                'choice_label' => 'name',
            ))
            ->add('picture',FileType::class,array(
            'label'=>'Logo', 'data_class' => null,
            'required'=>null
        ))
                ->add('url',UrlType::class)
                ->add('firstname')
                ->add('lastname');
    }


    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }


    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }


}