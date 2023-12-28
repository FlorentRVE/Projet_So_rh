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

    #[Route('/form', name: 'app_accueil_form')]
    public function form(): Response
    {

        return $this->render('accueil/form.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    #[Route('/admin', name: 'app_accueil_admin')]
    public function admin(): Response
    {

        return $this->render('administration/admin.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

}
