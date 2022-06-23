<?php

namespace App\Form;

use App\Entity\Categories;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategorieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la sous-catégorie',
                'required' => true,
                'attr' => [
                    'class' => 'tinymce'
                ],
            ])
            ->add('parent', EntityType::class, [
                'label' => 'Catégories :',
                'class' => Categories::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('c')
                    ->andWhere('c.type = 1');
                },
                'choice_label' => 'name',
                'expanded' => false,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categories::class,
        ]);
    }
}
