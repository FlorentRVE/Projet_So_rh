<?php

namespace App\Controller;

use App\Entity\DemandeAccompte;
use App\Form\DemandeAccompteType;
use App\Repository\DemandeAccompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class DemandeAccompteController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/demande_accompte', name: 'app_demande_accompte')]
    public function index(Request $request, MailerInterface $mailer, EntityManagerInterface $em): Response
    {
        $demandeAccompte = new DemandeAccompte();

        $form = $this->createForm(DemandeAccompteType::class, $demandeAccompte);
        $form->handleRequest($request);
        $formTitle = 'Demande d\'accompte bancaire';
        $user = $this->security->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $demandeAccompte->setDemandeur($user);
            $em->persist($demandeAccompte);
            $em->flush();

            // ================= Envoyer les données à l'adresse mail =================
            $email_from = $_ENV['EMAIL_FROM'];
            $email_to = $_ENV['EMAIL_TO'];

            $email = (new TemplatedEmail())
            ->from($email_from)
            ->to($email_to)
            ->cc($demandeAccompte->getService()->getEmailSecretariat(), $demandeAccompte->getService()->getEmailResponsable())
            ->subject($formTitle)
            ->htmlTemplate('email/demandeAccompte.html.twig')
            ->context([
                'formData' => $demandeAccompte,
                'formTitle' => $formTitle,
                'user' => $user->getUserIdentifier(),
            ]);

            $mailer->send($email);

            $this->addFlash('success', 'Formulaire soumis avec succès !');

            return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
        } else {
            $formErrors = [];
            foreach ($form->getErrors(true) as $error) {
                $formErrors[] = $error->getMessage();
            }

            $this->addFlash('danger', $formErrors);

            return $this->render('demandes/accompte/index.html.twig', [
                'form' => $form,
            ]);
        }
    }

    // ========================================= PARTIE ADMIN ===========================================
    // ======================= Afficher tous les formulaires de demande d'accompte ===========================

    #[Route('/demande_accompte_list', name: 'app_demande_accompte_index', methods: ['GET'])]
    public function list(Request $request, DemandeAccompteRepository $dar, PaginatorInterface $paginator): Response
    {
        $searchTerm = $request->query->get('search');

        $donnee = $dar->getDataFromSearch($searchTerm);

        $data = $paginator->paginate(
            $donnee,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('administration/list.html.twig', [
            'data' => $data,
            'searchTerm' => $searchTerm,
            'pathShow' => 'app_demande_accompte_show',
            'pathExcel' => 'app_excel_demande_accompte',
            'title' => 'Demande d\'accompte',
        ]);
    }

    // ======================= Afficher un formulaire de demande d'accompte ===========================

    #[Route('/demande_accompte_list/{id}', name: 'app_demande_accompte_show', methods: ['GET'])]
    public function show(DemandeAccompte $demandeAccompte): Response
    {
        return $this->render('demandes/accompte/show.html.twig', [
            'demande' => $demandeAccompte
        ]);
    }

    #[Route('/demande_accompte_list/{id}', name: 'app_demande_accompte_delete', methods: ['POST'])]
    public function delete(Request $request, DemandeAccompte $demandeAccompte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demandeAccompte->getId(), $request->request->get('_token'))) {
            $entityManager->remove($demandeAccompte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_demande_accompte_index', [], Response::HTTP_SEE_OTHER);
    }
}
