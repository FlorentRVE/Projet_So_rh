<?php

namespace App\Form;

use App\Entity\RendezVousRH;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RendezVousRhType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('rdvAvec')
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
            'class' => RendezVousRH::class,
        ]);
    }
}
