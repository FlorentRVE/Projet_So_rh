<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\QuestionrhType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class QuestionrhController extends AbstractController
{
    #[Route('/question', name: 'app_questionrh')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(QuestionrhType::class);
        $form->handleRequest($request);
        $formData = $request->request->all();
        $formTitle = 'Question RH';

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
            return $this->render('questionrh/index.html.twig', [
                'form' => $form
            ]);

        }

        return $this->render('questionrh/index.html.twig', [
            'form' => $form
        ]);
    }

    // #[Route('/email', name: 'app_questionrh')]
    // public function email(): Response
    // {
    //     $form = [
    //         'nom' => 'nom',
    //         'email' => 'email',
    //         'message' => 'message message message message message message message message message message message message message message message message message message message message message message message message message message message message message message ',
    //     ];

    //     $formTitle = 'Test Email';

    //     return $this->render('email/index.html.twig', [
    //         'formData' => $form,
    //         'formTitle' => $formTitle
    //     ]);
    // }
}
