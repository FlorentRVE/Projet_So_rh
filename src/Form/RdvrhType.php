<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
        ->add('telephone')
        ->add('email')
        ->add('message')
    ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
