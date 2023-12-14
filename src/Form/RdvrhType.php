<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RdvrhType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('pour', ChoiceType::class, [
            'choices' => [
                'DRH' => 'DRH',
                'RH' => 'RH',
                'Service Paie' => 'Service Paie',
                'Service Formation' => 'Service Formation',
                'Service Administratif' => 'Service Administratif',
                'Service Santé et Conditions de Travail' => 'Service Santé et Conditions de Travail',
            ],
        ])
        ->add('nom')
        ->add('prenom')
        ->add('service')
        ->add('telephone', TextType::class, [
            'constraints' => [
                new Assert\Regex([
                    'pattern' => '/^\d{10}$/',
                    'message' => 'Le numéro de téléphone doit être au format valide.',
                ]),
            ],
        ])
        ->add('email', EmailType::class, [
            'constraints' => [
                new Assert\Email([
                    'message' => 'L\'adresse email doit être au format valide.',
                ]),
            ],
        ])
        ->add('message', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
