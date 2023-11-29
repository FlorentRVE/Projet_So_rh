<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionrhType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pour', ChoiceType::class, [
                'choices' => [
                    'Formation' => 'Formation',
                    'Paie' => 'Paie',
                    'Dossier administratif' => 'Dossier administratif',
                    'Santé et conditions de travail' => 'Santé et conditions de travail',
                    'Autre' => 'Autre',
                ],
            ])
            ->add('nom')
            ->add('prenom')
            ->add('service')
            ->add('telephone')
            ->add('email')
            ->add('message')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
