<?php

namespace App\Form;

use App\Entity\ChangementAdresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangementAdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('service')
            ->add('fonction')
            ->add('numero')
            ->add('position', ChoiceType::class, [
                'choices' => [
                    'bis' => 'bis',
                    'ter' => 'ter',
                ],
                'required' => false,
            ])
            ->add('voie', TextareaType::class)
            ->add('commune')
            ->add('faitA')
            ->add('faitLe', DateType::class, [
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'class' => ChangementAdresse::class,
        ]);
    }
}
