<?php

namespace App\Controller;

use App\Entity\ChangementAdresse;
use App\Form\ChgmtAdresseType; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ChgmtAdresseController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/changement_adresse', name: 'app_chgmtadresse')]
    public function index(Request $request, MailerInterface $mailer, EntityManagerInterface $em): Response
    {
        $changementAdresse = new ChangementAdresse();
        $form = $this->createForm(ChgmtAdresseType::class, $changementAdresse);

        $form->handleRequest($request);
        $formTitle = 'Changement adresse';
        $user = $this->security->getUser()->getUserIdentifier();

        // dd($changementAdresse->getFaitLe()->format('d/m/Y'));        

        if ($form->isSubmitted() && $form->isValid()) {

            // dd($changementAdresse);

            $em->persist($changementAdresse);
            $em->flush();

            // ================= Envoyer les données à l'adresse mail =================

            $email = (new Email())
            ->from('expediteur@test.com')
            ->to('froulemmeyini-6535@yopmail.com')
            ->subject($formTitle)
            ->html($this->renderView('email/index.html.twig', [
                'formData' => $changementAdresse,
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

            return $this->render('chgmt_adresse/index.html.twig', [
                'form' => $form,
            ]);
        
     }

        return $this->render('chgmt_adresse/index.html.twig', [
            'form' => $form,
        ]);
    }
}
