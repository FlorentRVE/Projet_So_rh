<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class ChgmtAdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('Service', ChoiceType::class, [
                'choices' => [
                    'Formation' => 'Formation',
                    'Paie' => 'Paie',
                    'Dossier administratif' => 'Dossier administratif',
                    'Santé et conditions de travail' => 'Santé et conditions de travail',
                    'Autre' => 'Autre',
                ],
            ])
            ->add('fonction')
            ->add('adresse', TextareaType::class)
            ->add('commune', ChoiceType::class, [
                'choices' => [
                    'Saint-Paul' => 'Saint-Paul',
                    'Saint-Denis' => 'Saint-Denis',
                    'Saint-Louis' => 'Saint-Louis',                    
                ]
            ])
            ->add('fait', TextType::class, [
                'label' => 'Fait à',
            ])
            ->add('le', DateType::class, [
                'label' => 'le',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                
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
