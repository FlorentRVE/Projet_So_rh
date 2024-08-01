<?php

namespace App\Controller;

use App\Entity\ChangementCompte;
use App\Form\ChangementCompteType;
use App\Repository\ChangementCompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ChangementCompteController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    // ================================= Formulaire ==================================
    #[Route('/changement_compte', name: 'app_changement_compte')]
    public function index(Request $request, MailerInterface $mailer, EntityManagerInterface $em): Response
    {
        $changementCompte = new ChangementCompte();
        $form = $this->createForm(ChangementCompteType::class, $changementCompte);

        $files = $request->files->all();

        $form->handleRequest($request);
        $formTitle = 'Changement de compte bancaire';
        $user = $this->security->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            // ================== Gestion fichier ================
            if ($files) {
                $filesList = [];

                foreach ($files as $file) {
                    if (null !== $file) {
                        $directory = 'fichier';
                        $filename = uniqid().'.'.$file['rib']->getClientOriginalExtension();
                        $fileExtension = $file['rib']->getClientOriginalExtension();

                        if (!in_array($fileExtension, ['pdf', 'jpg', 'png'])) {
                            $this->addFlash('danger', ['Le fichier doit être au format PDF, JPG ou PNG']);

                            return $this->render('demandes/changement_compte/index.html.twig', [
                                'form' => $form,
                            ]);
                        }

                        $file['rib']->move($directory, $filename);
                        $filePath = $directory.'/'.$filename;
                        $filesList[] = $filePath;
                    } else {
                        $this->addFlash('danger', ['Le fichier est obligatoire']);

                        return $this->render('demandes/changement_compte/index.html.twig', [
                            'form' => $form,
                        ]);
                    }
                }
            }

            $changementCompte->setDemandeur($user);
            $em->persist($changementCompte);
            $em->flush();

            // ================= Envoyer les données à l'adresse mail =================
            $email_from = $_ENV['EMAIL_FROM'];
            $email_to = $_ENV['EMAIL_TO'];

            $email = (new TemplatedEmail())
            ->from($email_from)
            ->to($email_to)
            ->cc($changementCompte->getService()->getEmailSecretariat(), $changementCompte->getService()->getEmailSecretariat2() ?? 'null@test.fr', $changementCompte->getService()->getEmailResponsable())
            ->subject($formTitle)
            ->htmlTemplate('email/changementCompte.html.twig')
            ->context([
                'formData' => $changementCompte,
                'formTitle' => $formTitle,
                'user' => $user->getUserIdentifier(),
            ]);

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

            return $this->render('demandes/changement_compte/index.html.twig', [
                'form' => $form,
            ]);
        }
    }

    // ========================================= PARTIE ADMIN ===========================================
    // ======================= Affichage de tous les formulaires changement compte selon la recherche===========================

    #[Route('/changement_compte_list', name: 'app_changement_compte_index', methods: ['GET'])]
    public function list(Request $request, ChangementCompteRepository $ccr, PaginatorInterface $paginator): Response
    {
        $searchTerm = $request->query->get('search');

        $donnee = $ccr->getDataFromSearch($searchTerm);

        $data = $paginator->paginate(
            $donnee,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('administration/list.html.twig', [
            'data' => $data,
            'searchTerm' => $searchTerm,
            'pathShow' => 'app_changement_compte_show',
            'pathExcel' => 'app_excel_changement_compte',
            'title' => 'Changement de compte bancaire',
        ]);
    }

    // ======================= Affichage/Suppression d'un formulaire changement compte selon son id ===========================

    #[Route('/changement_compte_list/{id}', name: 'app_changement_compte_show', methods: ['GET'])]
    public function show(ChangementCompte $changementCompte): Response
    {
        return $this->render('demandes/changement_compte/show.html.twig', [
            'demande' => $changementCompte,
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
