<?php

namespace App\Controller;

use App\Form\RdvrhType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class RdvrhController extends AbstractController
{
    #[Route('/rdvrh', name: 'app_rdvrh')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(RdvrhType::class);
        $form->handleRequest($request);
        $formData = $request->request->all();
        $formTitle = 'Rendez-vous RH';

        if ($form->isSubmitted() && $form->isValid()) {

            $formDataSansToken = [];
            
            foreach ($formData as $formData) {

                foreach ($formData as $key => $value) {

                    if($key !== '_token') {

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
                'formTitle' => $formTitle
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
            return $this->render('rdvrh/index.html.twig', [
                'form' => $form
            ]);

        }

        return $this->render('rdvrh/index.html.twig', [
            'form' => $form
        ]);
    }
}
