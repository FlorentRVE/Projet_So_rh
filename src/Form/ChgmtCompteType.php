<?php

namespace App\Form;

use App\Entity\ChangementCompte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class ChgmtCompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('service')
            ->add('fonction')
            ->add('rib', FileType::class, [
                'label' => 'RIB',
                'mapped' => false,
            ])
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
            'class' => ChangementCompte::class,
        ]);
    }
}
