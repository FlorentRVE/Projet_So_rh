<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $errorMsg = 'Merci de vérifier vos identifiants';

        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error) {
            $errorArray = [];
            $errorArray[] = $errorMsg;
            $errorArray[] = $error->getMessage();
            $this->addFlash('danger', $errorArray);
        }

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): never
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    #[Route('/mentions_legales', name: 'app_mentions_legales')]
    public function mentionsLegales(): Response
    {
        return $this->render('login/mentions_legales.html.twig');
    }

    #[Route('/politique_de_confidentialite', name: 'app_politique_de_confidentialite')]
    public function confidentialite(): Response
    {
        return $this->render('login/politique_de_confidentialite.html.twig');
    }
}
