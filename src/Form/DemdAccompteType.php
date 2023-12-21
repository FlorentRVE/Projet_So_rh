<?php

namespace App\Form;

use App\Entity\DemandeAccompte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class DemdAccompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('service')
            ->add('fonction')
            ->add('accompteChiffre', NumberType::class)
            ->add('accompteLettre', TextType::class)
            ->add('motif', TextareaType::class)
            ->add('faitA')
            ->add('faitLe', DateType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime_immutable'
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'class' => DemandeAccompte::class,
        ]);
    }
}
