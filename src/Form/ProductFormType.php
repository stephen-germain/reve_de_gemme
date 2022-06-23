<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Products;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom du produit'
                ]
            ])
            ->add('description', TextType::class, [
                'required' => true,
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Description du produit'
                ]
            ])
            ->add('image', FileType::class, [
                'required' => true,
                'mapped' => false,
                'label' => 'Image du produit',
                'attr' =>[
                    'placeholder' => "image.jpg"
                ]
            ])
            ->add('categories', EntityType::class,[
                'label' => 'Sous-catégories',
                'class' => Categories::class,
                'query_builder' => function (EntityRepository $er){
                    return $er->createQueryBuilder('p')
                    ->andWhere('p.type = 2', 'p.parent = 1')
                    ->orWhere('p.type = 2', 'p.parent = 2')
                    ->orWhere('p.type = 2', 'p.parent = 3');
                },
                'choice_label' => 'name',
                'expanded' => false,
            ])
            // ->add('categories', ChoiceType::class,[
            //     'choices' => [
            //         'Bracelet' => [
            //             'Baroque' => 4,
            //             'Boules' => 5,
            //             'Test bracelet' => 8,
            //         ],
            //         'Collier' => [
            //             'Test collier' => 6,
            //         ],
            //         'Pierre' => [
            //             'Test pierre' => 7,
            //         ]
            //     ]
            // ])
            ->add('save', SubmitType::class, [
                'label' => 'Valider'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
