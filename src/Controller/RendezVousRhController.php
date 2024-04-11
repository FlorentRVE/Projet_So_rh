<?php

namespace App\Controller;

use App\Entity\RendezVousRH;
use App\Form\RendezVousRhType;
use App\Repository\RendezVousRHRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class RendezVousRhController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/rendez_vous', name: 'app_rendez_vous_rh')]
    public function index(Request $request, MailerInterface $mailer, EntityManagerInterface $em): Response
    {
        $rendezVousRh = new RendezVousRH();
        $form = $this->createForm(RendezVousRhType::class, $rendezVousRh);

        $form->handleRequest($request);
        $formTitle = 'Rendez-vous RH - ' . $rendezVousRh->getRdvAvec();
        $user = $this->security->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $currentDate = new \DateTimeImmutable();
            $rendezVousRh->setFaitLe($currentDate);
            $rendezVousRh->setDemandeur($user);

            $em->persist($rendezVousRh);
            $em->flush();

            // ================= Envoyer les données à l'adresse mail =================

            $email = (new Email())
            ->from('expediteur@test.com')
            ->to('froulemmeyini-6535@yopmail.com')
            ->cc($rendezVousRh->getService()->getEmailSecretariat(), $rendezVousRh->getService()->getEmailResponsable())
            ->subject($formTitle)
            ->html($this->renderView('email/rendezVousRh.html.twig', [
                'formData' => $rendezVousRh,
                'formTitle' => $formTitle,
                'user' => $user->getUserIdentifier(),
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

            return $this->render('demandes/rendez_vous_rh/index.html.twig', [
                'form' => $form,
            ]);
        }
    }

    // ========================================= PARTIE ADMIN ===========================================
    // ======================= Afficher tous les formulaires rendez-vous RH ===========================

    #[Route('/rendez_vous_rh_list', name: 'app_rendez_vous_rh_index', methods: ['GET'])]
    public function list(Request $request, RendezVousRHRepository $rdvr, PaginatorInterface $paginator): Response
    {
        $searchTerm = $request->query->get('search');

        $donnee = $rdvr->getDataFromSearch($searchTerm);

        $data = $paginator->paginate(
            $donnee,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('administration/list.html.twig', [
            'data' => $data,
            'searchTerm' => $searchTerm,
            'pathShow' => 'app_rendez_vous_rh_show',
            'pathExcel' => 'app_excel_rendez_vous_rh',
            'title' => 'Rendez-vous RH',
        ]);
    }

    // ======================= Afficher un formulaire rendez-vous RH ===========================

    #[Route('/rendez_vous_rh_list/{id}', name: 'app_rendez_vous_rh_show', methods: ['GET'])]
    public function show(RendezVousRH $rendezVousRH): Response
    {
        return $this->render('demandes/rendez_vous_rh/show.html.twig', [
            'demande' => $rendezVousRH
        ]);
    }

    #[Route('/rendez_vous_rh_list/{id}', name: 'app_rendez_vous_rh_delete', methods: ['POST'])]
    public function delete(Request $request, RendezVousRH $rendezVousRH, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezVousRH->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rendezVousRH);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rendez_vous_rh_index', [], Response::HTTP_SEE_OTHER);
    }
}
