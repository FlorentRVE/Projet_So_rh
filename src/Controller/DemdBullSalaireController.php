<?php

namespace App\Controller;

use App\Entity\DemandeBulletinSalaire;
use App\Form\DemdBullSalaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
class DemdBullSalaireController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/demande_bulletin_salaire', name: 'app_demdbullsalaire')]
    public function index(Request $request, MailerInterface $mailer, EntityManagerInterface $em): Response
    {      
       
        $demandeBulletinSalaire = new DemandeBulletinSalaire();

        $form = $this->createForm(DemdBullSalaireType::class, $demandeBulletinSalaire);

        $form->handleRequest($request);
        $formTitle = 'Demande de bulletin de salaire';
        $user = $this->security->getUser()->getUserIdentifier();

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($demandeBulletinSalaire);
            $em->flush();

            // ================= Envoyer les données à l'adresse mail =================

            $email = (new Email())
            ->from('expediteur@test.com')
            ->to('froulemmeyini-6535@yopmail.com')
            ->subject($formTitle)
            ->html($this->renderView('email/index.html.twig', [
                'formData' => $demandeBulletinSalaire,
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

            return $this->render('demd_bull_salaire/index.html.twig', [
                'form' => $form,
            ]);
        }

        return $this->render('demd_bull_salaire/index.html.twig', [
            'form' => $form,
        ]);
    }
}
