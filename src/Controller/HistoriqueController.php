<?php

namespace App\Controller;

use App\Repository\AttestationEmployeurRepository;
use App\Repository\ChangementAdresseRepository;
use App\Repository\ChangementCompteRepository;
use App\Repository\DemandeAccompteRepository;
use App\Repository\DemandeBulletinSalaireRepository;
use App\Repository\QuestionRHRepository;
use App\Repository\RendezVousRHRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/historique')]
class HistoriqueController extends AbstractController
{
    #[Route('/', name: 'app_accueil_historique')]
    public function historique(): Response
    {
        $user = $this->getUser();

        return $this->render('historique/historique.html.twig', [
            'controller_name' => 'AccueilController',
            'user' => $user        

        ]);
    }
    #[Route('/admin/{id}', name: 'app_admin_historique')]
    public function historiqueAdmin(Request $request, UserRepository $userRepository): Response
    {
        $id = $request->get('id');
        $user = $userRepository->find($id);

        return $this->render('historique/historique.html.twig', [
            'controller_name' => 'AccueilController',
            'user' => $user        

        ]);
    }

    #[Route('/attestation_employeur/{id}', name: 'app_attestation_employeur_historique')]
    public function historiqueAttestationEmployeur(Request $request, AttestationEmployeurRepository $attestationEmployeurRepository): Response
    {
        $id = $request->get('id');
        $attestationEmployeur = $attestationEmployeurRepository->find($id);

        return $this->render('historique/attestation_employeur.html.twig', [
            'controller_name' => 'AccueilController',
            'demande' => $attestationEmployeur

        ]);
    }
    #[Route('/changement_adresse/{id}', name: 'app_changement_adresse_historique')]
    public function historiqueChangementAdresse(Request $request, ChangementAdresseRepository $changementAdresseRepository): Response
    {
        $id = $request->get('id');
        $changementAdresse = $changementAdresseRepository->find($id);

        return $this->render('historique/changement_adresse.html.twig', [
            'controller_name' => 'AccueilController',
            'demande' => $changementAdresse

        ]);
    }
    #[Route('/changement_compte/{id}', name: 'app_changement_compte_historique')]
    public function historiqueChangementCompte(Request $request, ChangementCompteRepository $changementCompteRepository): Response
    {
        $id = $request->get('id');
        $changementCompte = $changementCompteRepository->find($id);

        return $this->render('historique/changement_compte.html.twig', [
            'controller_name' => 'AccueilController',
            'demande' => $changementCompte

        ]);
    }
    #[Route('/demande_accompte/{id}', name: 'app_demande_accompte_historique')]
    public function historiqueDemandeAccompte(Request $request, DemandeAccompteRepository $demandeAccompteRepository): Response
    {
        $id = $request->get('id');
        $demandeAccompte = $demandeAccompteRepository->find($id);

        return $this->render('historique/demande_accompte.html.twig', [
            'controller_name' => 'AccueilController',
            'demande' => $demandeAccompte

        ]);
    }
    #[Route('/demande_bulletin_salaire/{id}', name: 'app_demande_bulletin_salaire_historique')]
    public function historiqueDemandeBulletinSalaire(Request $request, DemandeBulletinSalaireRepository $demandeBulletinSalaireRepository): Response
    {
        $id = $request->get('id');
        $demandeBulletinSalaire = $demandeBulletinSalaireRepository->find($id);

        return $this->render('historique/demande_bulletin_salaire.html.twig', [
            'controller_name' => 'AccueilController',
            'demande' => $demandeBulletinSalaire

        ]);
    }
    #[Route('/question_rh/{id}', name: 'app_question_rh_historique')]
    public function historiqueQuestionRH(Request $request, QuestionRHRepository $questionRHRepository): Response
    {
        $id = $request->get('id');
        $questionRH = $questionRHRepository->find($id);

        return $this->render('historique/question_rh.html.twig', [
            'controller_name' => 'AccueilController',
            'demande' => $questionRH

        ]);
    }
    #[Route('/rendez_vous_rh/{id}', name: 'app_rendez_vous_rh_historique')]
    public function historiqueRendezVousRH(Request $request, RendezVousRHRepository $rendezVousRHRepository): Response
    {
        $id = $request->get('id');
        $rendezVousRH = $rendezVousRHRepository->find($id);

        return $this->render('historique/rendez_vous_rh.html.twig', [
            'controller_name' => 'AccueilController',
            'demande' => $rendezVousRH

        ]);
    }
}
