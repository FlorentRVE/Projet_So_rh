<?php

namespace App\Controller;

use App\Entity\DemandeBulletinSalaire;
use App\Form\DemandeBulletinSalaireType;
use App\Repository\DemandeBulletinSalaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class DemandeBulletinSalaireController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/demande_bulletin_salaire', name: 'app_demande_bulletin_salaire')]
    public function index(Request $request, MailerInterface $mailer, EntityManagerInterface $em): Response
    {
        $demandeBulletinSalaire = new DemandeBulletinSalaire();

        $form = $this->createForm(DemandeBulletinSalaireType::class, $demandeBulletinSalaire);

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
            ->cc($demandeBulletinSalaire->getService()->getEmailSecretariat())
            ->subject($formTitle)
            ->html($this->renderView('email/demandeBulletinSalaire.html.twig', [
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

            return $this->render('demande_bulletin_salaire/index.html.twig', [
                'form' => $form,
            ]);
        }

        return $this->render('demande_bulletin_salaire/index.html.twig', [
            'form' => $form,
        ]);
    }

    // ======================= PARTIE ADMIN ===========================

    #[Route('/demande_bulletin_salaire_list', name: 'app_demande_bulletin_salaire_index', methods: ['GET'])]
    public function list(Request $request, DemandeBulletinSalaireRepository $dbsr): Response
    {
        $searchTerm = $request->query->get('search');

        return $this->render('administration/list.html.twig', [
            'data' => $dbsr->getDataFromSearch($searchTerm),
            'searchTerm' => $searchTerm,
            'pathShow' => 'app_demande_bulletin_salaire_show',
            'pathExcel' => 'app_excel_demande_bulletin_salaire',
            'title' => 'Demande de bulletin de salaire',
        ]);
    }

    #[Route('/demande_bulletin_salaire_list/{id}', name: 'app_demande_bulletin_salaire_show', methods: ['GET'])]
    public function show(Request $request, DemandeBulletinSalaire $demandeBulletinSalaire, DemandeBulletinSalaireRepository $dbsr): Response
    {
        return $this->render('demande_bulletin_salaire/show.html.twig', [
            'demande' => $dbsr->find($demandeBulletinSalaire->getId($request->query->get('id'))),
        ]);
    }

    #[Route('/demande_bulletin_salaire_list/{id}', name: 'app_demande_bulletin_salaire_delete', methods: ['POST'])]
    public function delete(Request $request, DemandeBulletinSalaire $demandeBulletinSalaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demandeBulletinSalaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($demandeBulletinSalaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_demande_bulletin_salaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
