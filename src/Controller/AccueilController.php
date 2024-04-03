<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home()
    {
        return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    #[Route('/choix_formulaire', name: 'app_accueil_form')]
    public function form(): Response
    {
        return $this->render('accueil/choix_formulaire.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    // ======================= PARTIE ADMIN ==========================
    // =============== Choix des formulaires à consulter ==============
    
    #[Route('/gestion_formulaire', name: 'app_accueil_admin')]
    public function admin(): Response
    {
        return $this->render('administration/gestion_formulaire.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
}
