<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class AttEmployeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder            
            ->add('nom')
            ->add('prenom')
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\Email([
                        'message' => 'L\'adresse email doit être au format valide.',
                    ]),
                ],
            ])
            ->add('telephone', NumberType::class, [
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^\d{10}$/',
                        'message' => 'Le numéro de téléphone doit être au format valide.',
                    ]),
                ],
            ])
            ->add('service', ChoiceType::class, [
                'choices' => [
                    'Formation' => 'Formation',
                    'Paie' => 'Paie',
                    'Dossier administratif' => 'Dossier administratif',
                    'Santé et conditions de travail' => 'Santé et conditions de travail',
                    'Autre' => 'Autre',
                ],
            ])
            ->add('fonction')
            ->add('precision', TextareaType::class, [
                'required' => false
            ])
            ->add('recuperation', ChoiceType::class, [
                'choices' => [
                    'Sur place' => 'Sur place',
                    'Me l\'envoyer par email' => 'Me l\'envoyer par email',

                ],
                'placeholder' => 'Choisir une option',
                'multiple' => false,
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
