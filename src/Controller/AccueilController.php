<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Formulaire;


class AccueilController extends AbstractController
{
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

    #[Route('/form/{id}', name: 'app_form_show', methods: ['GET'])]
    public function show(Formulaire $formulaire): Response
    {
        $champs = $formulaire->getChamps();

        return $this->render('accueil/show.html.twig', [
            'formulaire' => $formulaire,
            'champs' => $champs
        ]);
    }
}
