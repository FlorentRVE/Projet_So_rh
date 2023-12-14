<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;


class AccueilController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_home')]
    public function home()
    {
        return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/accueil', name: 'app_accueil')]
    public function index(Request $request): Response
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
    public function admin() {

        return $this->render('accueil/admin.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

}
