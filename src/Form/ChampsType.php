<?php

namespace App\Form;

use App\Entity\Champs;
use App\Entity\Formulaire;
use App\Repository\FormulaireRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChampsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('formulaire', EntityType::class, [
            'class' => Formulaire::class,
            'choice_label' => 'label',
            'required' => true,
            'label' => 'Formulaire',
            'query_builder' => function (FormulaireRepository $fr) {
                if (isset($_GET['form_id'])) {
                    return $fr->createQueryBuilder('f')
                    ->where('f.id = :id')
                    ->setParameter('id', $_GET['form_id']);
                }
            },
        ])
        ->add('code', ChoiceType::class, [
            'label' => 'Type de champ',
            'choices' => [
                    'Identité' => [
                        'Nom Prénom' => '<div class="flex flex-wrap font-semibold gap-4"><div class="flex flex-col gap-2 flex-1"><label for="nom" class="text-slate-50">Nom:</label><input type="text" id="nom" name="nom" placeholder="Nom" class="rounded-lg p-4"></div><div class="flex flex-col gap-2 flex-1"><label for="prenom" class="text-slate-50">Prénom:</label><input type="text" id="prenom" name="prenom" placeholder="Prénom" class="rounded-lg p-4"></div></div>',
                        'Email' => '<div class="flex flex-col gap-2 flex-1"><label for="email" class="text-slate-50">Email:</label><input type="email" id="email" name="email" placeholder="Email" class="rounded-lg p-4"></div>',
                        'Service' => '<div class="flex flex-col gap-2 flex-1"><label for="service" class="text-slate-50">Service:</label><input type="text" id="service" name="service" placeholder="Service" class="rounded-lg p-4"></div>',
                        'Fonction' => '<div class="flex flex-col gap-2 flex-1"><label for="fonction" class="text-slate-50">Fonction:</label><input type="text" id="fonction" name="fonction" placeholder="Fonction" class="rounded-lg p-4"></div>',
                        'Numéro de téléphone' => '<div class="flex flex-col gap-2 flex-1"><label for="telephone" class="text-slate-50">Numéro de téléphone :</label><input type="number" name="telephone" id="telephone" class="rounded-lg w-[50%] p-2"></div>',
                        'Nouvelle adresse' => '<div class="flex flex-col gap-2 flex-1"><label for="adresse" class="text-slate-50">Ma nouvelle adresse est :</label><textarea id="adresse" name="adresse" placeholder="Adresse " class="rounded-lg p-4"></textarea></div>',
                    ],
                    'Demande' => [
                        'Motif de la demande' => '<div class="flex flex-col gap-2 flex-1"><label for="motif" class="text-slate-50">Motif de la demande:</label><textarea id="motif" name="motif" placeholder="Motif de la demande" class="rounded-lg p-4"></textarea></div>',
                        'Message' => '<div class="flex flex-col gap-2 flex-1"><label for="message" class="text-slate-50">Votre message:</label><textarea id="message" name="message" placeholder="Message" class="rounded-lg p-4"></textarea></div>',
                        'Question' => '<div class="flex flex-col gap-2 flex-1"><label for="question" class="text-slate-50">Votre question:</label><textarea id="question" name="question" placeholder="Question" class="rounded-lg p-4"></textarea></div>',
                        'Rendez-vous avec ...' => '<div class="flex flex-col gap-2 flex-1"><label for="rendezvous" class="text-slate-50">Rendez-vous :</label><select id="rendezvous" name="rendezvous" class="rounded-lg w-[50%] p-2"><option value="drh">DRH</option><option value="paie">Le service Paie</option><option value="formation">Le service Formation</option><option value="administratif">Le service Administratif</option><option value="sante">Le service Santé et Conditions de travail</option></select></div>',
                        'Ma demande concerne ...' => '<div class="flex flex-col gap-2 flex-1"><label for="pour" class="text-slate-50">Demande pour :</label><select id="pour" name="pour" class="rounded-lg w-[50%] p-2"><option value="paie">La Paie</option><option value="formation">La Formation</option><option value="administratif">Mon dossier Administratif</option><option value="autres">Autres</option></select></div>',
                        'Demande duplicata bulletin salaire' => '<div class="flex flex-col gap-2 flex-1"><p class="text-slate-50">Je souhaite recevoir le duplicata de mes bulletin de salaire pour la période :</p><div class="flex gap-4"><div class="flex flex-col gap-2 flex-1"><label for="du" class="text-slate-50">Du :</label><input type="date" name="du" id="du" class="rounded-lg p-2"></div><div class="flex flex-col gap-2 flex-1"><label for="au" class="text-slate-50">Au :</label><input type="date" name="au" id="au" class="rounded-lg p-2"></div></div></div>',
                        'Accompte' => '<div class="flex flex-col gap-2 flex-1"><label for="montant" class="text-slate-50">Je souhaite demander un accompte de :</label><input type="number" name="montant" id="montant" placeholder="Taper le montant en chiffres" class="rounded-lg w-[50%] p-2"><input type="text" name="lettre" id="lettre" placeholder="Taper le montant en lettres" class="rounded-lg p-2"></div>',
                    ],
                    'Fichier' => [
                        'Joindre fichier' => '<div class="flex flex-col gap-2 flex-1"><label for="file" class="text-slate-50">Fichier :</label><input type="file" name="file" id="file" class="rounded-2xl w-[50%] p-2 bg-blue-600 text-slate-50 font-normal"></div>',
                        'Joindre RIB' => '<div class="flex flex-col gap-2 flex-1"><label for="rib" class="text-slate-50">Joindre mon RIB :</label><input type="file" name="rib" id="rib" class="rounded-2xl w-[50%] p-2 bg-blue-600 text-slate-50 font-normal"></div>',
                        'Joindre justificatif' => '<div class="flex flex-col gap-2 flex-1"><label for="justificatif" class="text-slate-50">Joindre mon Justificatif :</label><input type="file" name="justificatif" id="justificatif" class="rounded-2xl w-[50%] p-2 bg-blue-600 text-slate-50 font-normal"></div>',
                    ],
                    'Autres' => [
                        'Du ... Au (Date)' => '<div class="flex gap-4"><div class="flex flex-col gap-2 flex-1"><label for="du" class="text-slate-50">Du :</label><input type="date" name="du" id="du" class="rounded-lg w-[50%] p-2"></div><div class="flex flex-col gap-2 flex-1"><label for="au" class="text-slate-50">Au :</label><input type="date" name="au" id="au" class="rounded-lg w-[50%] p-2"></div></div>',
                        'Date' => '<div class="flex flex-col gap-2 flex-1"><label for="date" class="text-slate-50">Date :</label><input type="date" name="date" id="date" class="rounded-lg w-[50%] p-2"></div>',
                        'Fait à ... le' => '<div class="flex flex-wrap font-semibold gap-4"><div class="flex flex-col gap-2 flex-1"><label for="a" class="text-slate-50">Fait à :</label><input type="text" id="a" name="a" placeholder="Fait à ..." class="rounded-lg p-4"></input></div><div class="flex flex-col gap-2 flex-1"><label for="le" class="text-slate-50">Le :</label><input type="date" name="le" id="le" class="rounded-lg w-[50%] p-2"></div></div>',
                        'Comment récupérer mon document ...' => '<div class="flex flex-col gap-2 flex-1"><label for="recup" class="text-slate-50">Je souhaite récupérer mon document :</label><div class="flex gap-4"><label for="recuperation" class="text-slate-50"><input type="radio" id="recuperation" name="recuperation" value="presentiel" class="rounded-lg p-4">Sur place</label><label for="recuperation" class="text-slate-50"><input type="radio" id="recuperation" name="recuperation" value="mail" class="rounded-lg p-4">Par mail</label></div></div>',
                    ],
                ]])
                ->add('label', null, [
                    'attr' => ['placeholder' => 'Nom_du_Formulaire_type de champs ( Exemple : Changement_adresse_nom )'],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Champs::class,
        ]);
    }
}
