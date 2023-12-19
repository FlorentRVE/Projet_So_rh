<?php

namespace App\Controller;

use App\Form\AttEmployeurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class AttEmployeurController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/attestation_employeur', name: 'app_attemployeur')]
    public function index(Request $request, MailerInterface $mailer): Response
    {      
       
        $form = $this->createForm(AttEmployeurType::class);
        $form->handleRequest($request);
        $formData = $request->request->all();
        $formTitle = 'Demande d\'attestation employeur';
        $user = $this->security->getUser()->getUserIdentifier();

        if ($form->isSubmitted() && $form->isValid()) {
            $formDataSansToken = [];

            foreach ($formData as $formData) {
                foreach ($formData as $key => $value) {
                    if ('_token' !== $key) {
                        $formDataSansToken[$key] = $value;
                    }
                }
            }

            // ================= Envoyer les données à l'adresse mail =================

            $email = (new Email())
            ->from('expediteur@test.com')
            ->to('froulemmeyini-6535@yopmail.com')
            ->subject($formTitle)
            ->html($this->renderView('email/index.html.twig', [
                'formData' => $formDataSansToken,
                'formTitle' => $formTitle,
                'user' => $user,
            ]));

            $mailer->send($email);

            $this->addFlash('success', 'Formulaire soumis avec succès !');

            return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
        } else {
            $formErrors = [];
            foreach ($form->getErrors(true) as $error) {
                $formErrors[] = $error->getMessage();
            }

            $this->addFlash('danger', $formErrors);

            return $this->render('att_employeur/index.html.twig', [
                'form' => $form,
            ]);
        }

        return $this->render('att_employeur/index.html.twig', [
            'form' => $form,
        ]);
    }
    
}
