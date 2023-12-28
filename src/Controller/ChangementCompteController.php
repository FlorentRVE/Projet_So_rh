<?php

namespace App\Controller;

use App\Entity\ChangementCompte;
use App\Form\ChangementCompteType;
use App\Repository\ChangementCompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ChangementCompteController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/changement_compte', name: 'app_changement_compte')]
    public function index(Request $request, MailerInterface $mailer, EntityManagerInterface $em): Response
    {
        $changementCompte = new ChangementCompte();      
        $form = $this->createForm(ChangementCompteType::class, $changementCompte);

        $files = $request->files->all();

        $form->handleRequest($request);
        $formTitle = 'Changement de compte bancaire';
        $user = $this->security->getUser()->getUserIdentifier();

        if ($form->isSubmitted() && $form->isValid()) {

            // ================== Gestion fichier ================

            if ($files) {

                $filesList= [];

                foreach ($files as $file) {

                    if ($file !== null) {

                        // $fileExtension = $file['rib']->getClientOriginalExtension();

                        // if ($fileExtension !== 'pdf') {
                        //     $errors['file'] = ['Le fichier doit être au format PDF'];
                            
                        // } else {

                            $directory = 'fichier'; 
                            $filename = uniqid().'.'.$file['rib']->getClientOriginalExtension();
                            $file['rib']->move($directory, $filename);
                            $filePath = $directory.'/'.$filename;

                            $filesList[] = $filePath;
                        // }

                    } else {

                        $errors['file'] = ['Le fichier est obligatoire'];
                    }
                }
            }

            $em->persist($changementCompte);
            $em->flush();

            // ================= Envoyer les données à l'adresse mail =================

            $email = (new Email())
            ->from('expediteur@test.com')
            ->to('froulemmeyini-6535@yopmail.com')
            ->cc($changementCompte->getService()->getEmailSecretariat())
            ->subject($formTitle)
            ->html($this->renderView('email/changementCompte.html.twig', [
                'formData' => $changementCompte,
                'formTitle' => $formTitle,
                'user' => $user,
            ]));

            if (isset($filesList)) {

                foreach ($filesList as $filePath) {
                    $email->attachFromPath($filePath);
                }
            }
            
            $mailer->send($email);

            if (isset($filesList)) {

                foreach ($filesList as $filePath) {
                    unlink($filePath);
                }
            }

            $this->addFlash('success', 'Formulaire soumis avec succès !');

            return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
        } else {
            $formErrors = [];
            foreach ($form->getErrors(true) as $error) {
                $formErrors[] = $error->getMessage();
            }

            $this->addFlash('danger', $formErrors);

            return $this->render('changement_compte/index.html.twig', [
                'form' => $form,
            ]);
        }

        return $this->render('changement_compte/index.html.twig', [
            'form' => $form,
        ]);

    }

    // ======================= PARTIE ADMIN ===========================

    #[Route('/changement_compte_list', name: 'app_changement_compte_index', methods: ['GET'])]
    public function list(Request $request, ChangementCompteRepository $ccr): Response
    {
        $searchTerm = $request->query->get('search');

        return $this->render('administration/list.html.twig', [
            'data' => $ccr->getDataFromSearch($searchTerm),
            'searchTerm' => $searchTerm,
            'pathShow' => 'app_changement_compte_show',
            'pathExcel' => 'app_excel_changement_compte',
            'title' => 'Changement de compte bancaire',
        ]);
    }

    #[Route('/changement_compte_list/{id}', name: 'app_changement_compte_show', methods: ['GET'])]
    public function show(Request $request, ChangementCompte $changementCompte, ChangementCompteRepository $ccr): Response
    {
        return $this->render('changement_compte/show.html.twig', [
            'demande' => $ccr->find($changementCompte->getId($request->query->get('id'))),
        ]);
    }

    #[Route('/changement_compte_list/{id}', name: 'app_changement_compte_delete', methods: ['POST'])]
    public function delete(Request $request, ChangementCompte $changementCompte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$changementCompte->getId(), $request->request->get('_token'))) {
            $entityManager->remove($changementCompte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_changement_compte_index', [], Response::HTTP_SEE_OTHER);
    }
}
