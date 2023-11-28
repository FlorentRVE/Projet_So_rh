<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Formulaire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(Request $request): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'message' => $request->query->get('message'),
        ]);
    }

    #[Route('/form', name: 'app_accueil_form')]
    public function form(): Response
    {
        return $this->render('accueil/form.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    // #[Route('/form/{id}', name: 'app_form_show', methods: ['GET'])]
    // public function show(Formulaire $formulaire): Response
    // {
    //     $champs = $formulaire->getChamps();

    //     return $this->render('accueil/show.html.twig', [
    //         'formulaire' => $formulaire,
    //         'champs' => $champs
    //     ]);
    // }

    #[Route('/form/{id}', name: 'app_form_show', methods: ['GET', 'POST'])]
    public function show(Formulaire $formulaire, Request $request, MailerInterface $mailer): Response
    {
        $champs = $formulaire->getChamps();
        $formTitle = $formulaire->getLabel();

        $file = $request->files->get('justificatif');
        $formData = $request->request->all();

        if ($formData) {

            if ($file) {
                $directory = 'fichier'; 
                $filename = uniqid().'.'.$file->getClientOriginalExtension();
                $file->move($directory, $filename);
                $filePath = $directory.'/'.$filename;
            }
            
            // dd($filePath);
            
            // Envoyer les données à l'adresse mail
            $email = (new Email())
            ->from('expediteur@test.com')
            ->to('froulemmeyini-6535@yopmail.com')
            ->subject($formTitle)
            ->html($this->renderView('email/index.html.twig', [
                'formData' => $formData,
                'formTitle' => $formTitle
            ]));

            if (isset($filePath)) {
                $email->attachFromPath($filePath);
            }
            
            $mailer->send($email);
            
            unlink($filePath);
    
            return $this->redirectToRoute('app_accueil', ['message' => 'Votre formulaire a bien été envoyé !'], Response::HTTP_SEE_OTHER);
        }

        return $this->render('accueil/show.html.twig', [
            'formulaire' => $formulaire,
            'champs' => $champs
        ]);
    }
}