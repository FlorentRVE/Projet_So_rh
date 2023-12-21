<?php

namespace App\Controller;

use App\Entity\ChangementCompte;
use App\Form\ChgmtCompteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ChgmtCompteController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/changement_compte', name: 'app_chgmtcompte')]
    public function index(Request $request, MailerInterface $mailer, EntityManagerInterface $em): Response
    {
        $changementCompte = new ChangementCompte();      
        $form = $this->createForm(ChgmtCompteType::class, $changementCompte);

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

            return $this->render('chgmt_compte/index.html.twig', [
                'form' => $form,
            ]);
        }

        return $this->render('chgmt_compte/index.html.twig', [
            'form' => $form,
        ]);

    }
}
