<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class DemdBullSalaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
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
            ->add('du', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',

            ])
            ->add('au', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                
            ])
            ->add('motif', TextareaType::class)
            ->add('recuperation', ChoiceType::class, [
                'choices' => [
                    'Sur place' => 'Sur place',
                    'Me l\'envoyer par email' => 'Me l\'envoyer par email',
                ],
                'multiple' => false,
            ])
        ;

        // ============= TEST EVENT LISTENER =================
        $builder->addEventListener( FormEvents::PRE_SET_DATA, function (FormEvent $event) {

            $data = $event->getData();
            $form = $event->getForm();

            if($data) dd($data);

            if (isset($data['recuperation'])) {

                if ($data['recuperation'] == 'Sur place') {
                    $form->add('numero', NumberType::class);
                } else if($data['recuperation'] == 'Me l\'envoyer par email') {
                    $form->add('email', EmailType::class);
                    
                }
            }
        })
        ;
        // ==================================
        $builder
            ->add('fait', ChoiceType::class, [
                'choices' => [
                    'Saint-Paul' => 'Saint-Paul',
                    'Saint-Denis' => 'Saint-Denis',
                    'Saint-Louis' => 'Saint-Louis',                    
                ]
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
