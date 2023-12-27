<?php

namespace App\Controller;

use App\Entity\ChangementAdresse;
use App\Form\ChangementAdresseType;
use App\Repository\ChangementAdresseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ChangementAdresseController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/changement_adresse', name: 'app_changement_adresse')]
    public function index(Request $request, MailerInterface $mailer, EntityManagerInterface $em): Response
    {
        $changementAdresse = new ChangementAdresse();
        $form = $this->createForm(ChangementAdresseType::class, $changementAdresse);

        $form->handleRequest($request);
        $formTitle = 'Changement adresse';
        $user = $this->security->getUser()->getUserIdentifier();

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($changementAdresse);
            $em->flush();

            // ================= Envoyer les données à l'adresse mail =================

            $email = (new Email())
            ->from('expediteur@test.com')
            ->to('froulemmeyini-6535@yopmail.com')
            ->cc($changementAdresse->getService()->getEmailSecretariat())
            ->subject($formTitle)
            ->html($this->renderView('email/changementAdresse.html.twig', [
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

            return $this->render('changement_adresse/index.html.twig', [
                'form' => $form,
            ]);
        
     }

        return $this->render('changement_adresse/index.html.twig', [
            'form' => $form,
        ]);
    }

        // ======================= PARTIE ADMIN ===========================

        #[Route('/changement_adresse_list', name: 'app_changement_adresse_index', methods: ['GET'])]
        public function list(Request $request, ChangementAdresseRepository $car): Response
        {
            $searchTerm = $request->query->get('search');
    
            return $this->render('changement_adresse/list.html.twig', [
                'changement_adresses' => $car->getDataFromSearch($searchTerm),
                'searchTerm' => $searchTerm,
            ]);
        }

        #[Route('/changement_adresse_list/{id}', name: 'app_changement_adresse_show', methods: ['GET'])]
        public function show(Request $request, ChangementAdresse $changementAdresse, ChangementAdresseRepository $car): Response
        {
            return $this->render('changement_adresse/show.html.twig', [
                'demande' => $car->find($changementAdresse->getId($request->query->get('id'))),
            ]);
        }
    
        #[Route('/changement_adresse_list/{id}', name: 'app_changement_adresse_delete', methods: ['POST'])]
        public function delete(Request $request, ChangementAdresse $changementAdresse, EntityManagerInterface $entityManager): Response
        {
            if ($this->isCsrfTokenValid('delete'.$changementAdresse->getId(), $request->request->get('_token'))) {
                $entityManager->remove($changementAdresse);
                $entityManager->flush();
            }
    
            return $this->redirectToRoute('app_changement_adresse_index', [], Response::HTTP_SEE_OTHER);
        }
}
