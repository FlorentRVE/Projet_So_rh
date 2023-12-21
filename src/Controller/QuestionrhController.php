<?php

namespace App\Controller;

use App\Entity\QuestionRH;
use App\Form\QuestionrhType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class QuestionrhController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/question', name: 'app_questionrh')]
    public function index(Request $request, MailerInterface $mailer, EntityManagerInterface $em): Response
    {
        $questionRh = new QuestionRH();
        $form = $this->createForm(QuestionrhType::class, $questionRh);

        $form->handleRequest($request);
        $formTitle = 'Question RH';
        $user = $this->security->getUser()->getUserIdentifier();

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($questionRh);
            $em->flush();
            
            // ================= Envoyer les données à l'adresse mail =================

            $email = (new Email())
            ->from('expediteur@test.com')
            ->to('froulemmeyini-6535@yopmail.com')
            ->subject($formTitle)
            ->html($this->renderView('email/index.html.twig', [
                'formData' => $questionRh,
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

            return $this->render('questionrh/index.html.twig', [
                'form' => $form,
            ]);
        }

        return $this->render('questionrh/index.html.twig', [
            'form' => $form,
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

    //     $user = $this->security->getUser()->getUserIdentifier();

    //     return $this->render('email/index.html.twig', [
    //         'formData' => $form,
    //         'formTitle' => $formTitle,
    //         'user' => $user
    //     ]);
    // }
}
