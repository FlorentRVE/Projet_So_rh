<?php

namespace App\Controller;

use App\Entity\AttestationEmployeur;
use App\Form\AttestationEmployeurType;
use App\Repository\AttestationEmployeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class AttestationEmployeurController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/attestation_employeur', name: 'app_attestation_employeur')]
    public function index(Request $request, MailerInterface $mailer, EntityManagerInterface $em): Response
    {
        $attestationEmployeur = new AttestationEmployeur();
        $form = $this->createForm(AttestationEmployeurType::class, $attestationEmployeur);
        $form->handleRequest($request);
        $formTitle = 'Demande d\'attestation employeur';
        $user = $this->security->getUser()->getUserIdentifier();

        if ($form->isSubmitted() && $form->isValid()) {
            $currentDate = new \DateTimeImmutable();
            $attestationEmployeur->setFaitLe($currentDate);
            $attestationEmployeur->setDemandeur($this->security->getUser());

            $em->persist($attestationEmployeur);
            $em->flush();

            // ================= Envoyer les données à l'adresse mail =================

            $email = (new Email())
            ->from('expediteur@test.com')
            ->to('froulemmeyini-6535@yopmail.com')
            ->cc($attestationEmployeur->getService()->getEmailSecretariat())
            ->subject($formTitle)
            ->html($this->renderView('email/attestationEmployeur.html.twig', [
                'formData' => $attestationEmployeur,
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

            return $this->render('demandes/attestation_employeur/index.html.twig', [
                'form' => $form,
            ]);
        }

    }

    // ======================= PARTIE ADMIN ===========================

    #[Route('/attestation_employeur_list', name: 'app_attestation_employeur_index', methods: ['GET'])]
    public function list(Request $request, AttestationEmployeurRepository $ar, PaginatorInterface $paginator): Response
    {
        $searchTerm = $request->query->get('search');

        $donnee = $ar->getDataFromSearch($searchTerm);

        $data = $paginator->paginate(
            $donnee,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('administration/list.html.twig', [
            'data' => $data,
            'searchTerm' => $searchTerm,
            'pathShow' => 'app_attestation_employeur_show',
            'pathExcel' => 'app_excel_attestation_employeur',
            'title' => 'Attestation employeur',
        ]);
    }

    #[Route('/attestation_employeur_list/{id}', name: 'app_attestation_employeur_show', methods: ['GET'])]
    public function show(AttestationEmployeur $attestationEmployeur): Response
    {
        return $this->render('demandes/attestation_employeur/show.html.twig', [
            'demande' => $attestationEmployeur,
        ]);
    }

    #[Route('/attestation_employeur_list/{id}', name: 'app_attestation_employeur_delete', methods: ['POST'])]
    public function delete(Request $request, AttestationEmployeur $attestationEmployeur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attestationEmployeur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($attestationEmployeur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_attestation_employeur_index', [], Response::HTTP_SEE_OTHER);
    }
}
