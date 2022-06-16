<?php

namespace App\Form;

use App\Entity\Expositions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ExpostionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $hours = [];
        for($i = 8; $i <= 18; $i++){
            array_push($hours, strval($i));
        }
        $builder
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'class' => 'tinymce'
                ],
                // 'sanitize_html' => true
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => 'tinymce'
                ],
                // 'sanitize_html' => true
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'Code postal',
                'attr' => [
                    'class' => 'tinymce'
                ],
                // 'sanitize_html' => true,
                'trim' => true
            ])
            ->add('beginAt', TimeType::class, [
                'label' => 'Heure de début d\'expostion',
                'widget' => 'choice',
                'placeholder' => 'Select a value',
                'minutes' => ["00", "30"],
                'hours' => $hours,
            ])
            ->add('endAt', TimeType::class, [
                'label' => 'Heure de fin d\'expostion',
                'widget' => 'choice',
                'placeholder' => 'Select a value',
                'minutes' => ["00", "30"],
                'hours' => $hours,
            ])
            ->add('day', DateType::class, [
                'label' => 'Jour de l\'expostion',
                'widget' => 'single_text',
                //'format' => 'dd/MM/yyyy',
                //'html5' => false,
                // 'attr' => [
                //     'class' => 'js-datepicker'
                // ],
                
            ])
            ->add('save', SubmitType::class, [
                'label' => 'valider',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Expositions::class,
        ]);
    }
}
