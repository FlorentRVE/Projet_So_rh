<?php

namespace App\Controller;

use App\Entity\Formulaire;
use App\Repository\FormulaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bundle\SecurityBundle\Security;

class AccueilController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_home')]
    public function home()
    {
        return $this -> redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/accueil', name: 'app_accueil')]
    public function index(Request $request): Response
    {        
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    #[Route('/form', name: 'app_accueil_form')]
    public function form(FormulaireRepository $formulaireRepository): Response
    {

        $formulaire = $formulaireRepository->findAll();

        return $this->render('accueil/form.html.twig', [
            'controller_name' => 'AccueilController',
            'formulaire' => $formulaire
        ]);
    }

    #[Route('/form/{id}', name: 'app_form_show', methods: ['GET', 'POST'])]
    public function show(Formulaire $formulaire, Request $request, MailerInterface $mailer): Response
    {
        $formTitle = $formulaire->getLabel();
        $champs = $formulaire->getChamps();
        
        $formData = $request->request->all();
        $files = $request->files->all();
        $errors = [];
        $user = $this->security->getUser()->getUserIdentifier();
        
        if ($formData) {

            // ================== Gestion fichier ================
            if ($files) {

                $filesList= [];

                foreach ($files as $file) {

                    if ($file !== null) {

                        $fileExtension = $file->getClientOriginalExtension();

                        if ($fileExtension !== 'pdf') {
                            $errors['file'] = ['Le fichier doit être au format PDF'];
                            
                        } else {

                            $directory = 'fichier'; 
                            $filename = uniqid().'.'.$file->getClientOriginalExtension();
                            $file->move($directory, $filename);
                            $filePath = $directory.'/'.$filename;

                            $filesList[] = $filePath;
                        }

                    } else {

                        $errors['file'] = ['Le fichier est obligatoire'];
                    }
                }
            }

            // ============= Validation =============

            $validator = Validation::createValidator();
            
            foreach ($formData as $field => $value) {

                switch ($field) {
                    case 'telephone':
                        $violations = $validator->validate($value, [
                            new Assert\NotBlank(),
                            new Assert\Regex([
                                'pattern' => '/^0[1-9]([-. ]?[0-9]{2}){4}$/',
                            ]),
                        ]);
                        break;

                    case 'adresse':
                        $violations = $validator->validate($value, [
                            new Assert\NotBlank(),
                            new Assert\Regex([
                                'pattern' => '/^\d+ [\w\s]+ \d{5} [\w\s-]+$/',
                            ]),
                        ]);
                        break;

                    case 'email':
                        $violations = $validator->validate($value, [
                            new Assert\NotBlank(),
                            new Assert\Email(),
                        ]);
                        break;

                    default:
                        $violations = $validator->validate($value, [
                            new Assert\NotBlank(),
                        ]);
                        break;
                }
                
                if (count($violations) > 0) {

                    $errors[$field] = [];

                    foreach ($violations as $violation) {
                        $errors[$field][] = $violation->getMessage();
                    }
                }
            }

            if (count($errors) > 0) {
                
                $this->addFlash('danger', $errors);
                return $this->render('accueil/show.html.twig', [
                    'formulaire' => $formulaire,
                    'champs' => $champs,
                ]);

            }

            // ================= Envoyer les données à l'adresse mail =================
            
            $email = (new Email())
            ->from('expediteur@test.com')
            ->to('froulemmeyini-6535@yopmail.com')
            ->subject($formTitle)
            ->html($this->renderView('email/index.html.twig', [
                'formData' => $formData,
                'formTitle' => $formTitle,
                'user' => $user

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
    
            $this->addFlash('success', 'Votre formulaire a bien été envoyé !');
            return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('accueil/show.html.twig', [
            'formulaire' => $formulaire,
            'champs' => $champs
        ]);
    }
}