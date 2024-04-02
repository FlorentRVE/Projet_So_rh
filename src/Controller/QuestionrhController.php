<?php

namespace App\Controller;

use App\Entity\QuestionRH;
use App\Form\QuestionrhType;
use App\Repository\QuestionRHRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
            $currentDate = new \DateTimeImmutable();
            $questionRh->setFaitLe($currentDate);
            $questionRh->setDemandeur($this->security->getUser());

            $em->persist($questionRh);
            $em->flush();

            // ================= Envoyer les données à l'adresse mail =================

            $email = (new Email())
            ->from('expediteur@test.com')
            ->to('froulemmeyini-6535@yopmail.com')
            ->cc($questionRh->getService()->getEmailSecretariat())
            ->subject($formTitle)
            ->html($this->renderView('email/questionRh.html.twig', [
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

            return $this->render('demandes/question_rh/index.html.twig', [
                'form' => $form,
            ]);
        }
    }

    // ======================= PARTIE ADMIN ===========================
   
    #[Route('/questionrh_list', name: 'app_questionrh_index', methods: ['GET'])]
    public function list(Request $request, QuestionRHRepository $qr, PaginatorInterface $paginator): Response
    {
        $searchTerm = $request->query->get('search');

        $donnee = $qr->getDataFromSearch($searchTerm);

        $data = $paginator->paginate(
            $donnee,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('administration/list.html.twig', [
            'data' => $data,
            'searchTerm' => $searchTerm,
            'pathShow' => 'app_questionrh_show',
            'pathExcel' => 'app_excel_question_rh',
            'title' => 'Questions RH',
        ]);
    }

    #[Route('/questionrh_list/{id}', name: 'app_questionrh_show', methods: ['GET'])]
    public function show(QuestionRH $questionRH): Response
    {
        return $this->render('demandes/question_rh/show.html.twig', [
            'demande' => $questionRH
        ]);
    }

    #[Route('/questionrh_list/{id}', name: 'app_questionrh_delete', methods: ['POST'])]
    public function delete(Request $request, QuestionRH $questionRH, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$questionRH->getId(), $request->request->get('_token'))) {
            $entityManager->remove($questionRH);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_questionrh_index', [], Response::HTTP_SEE_OTHER);
    }
}
