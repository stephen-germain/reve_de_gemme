<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre prénom',
                ]
            ])
            ->add('nom', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre nom',
                ]
            ])
            ->add('adresseEmail', EmailType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Adresse email',
                ]
            ])
            ->add('objet', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Objet'
                ]
            ])
            ->add('message', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Votre message',
                    'maxLength' => 1000,
                ],
                'help' => '1000 caractères maximum'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
