<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/nouvel_utilisateur', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_user_index');
        } else {
            $formErrors = [];
            foreach ($form->getErrors(true) as $error) {
                $formErrors[] = $error->getMessage();
            }

            $this->addFlash('danger', $formErrors);

            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form,
            ]);
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/resetuser', name: 'app_resetuser')]
    public function massuser(UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $users = $userRepository->findAll();

        foreach ($users as $entity) {
            $entityManager->remove($entity);
        }
        $entityManager->flush();

        $user_array = [
            [
                'username' => 'admin',
                'matricule' => 'adminadmin',
            ],
        ];

        foreach( $user_array as $usera ) {

            $user = new User();
            $user->setUsername($usera['username']);
            $user->setRoles(['ROLE_ADMIN', 'ROLE_ACTIF', 'ROLE_USER']);
            // $user->setRoles(['ROLE_ACTIF', 'ROLE_USER']);

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $usera['matricule']
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

        }

        return new Response('Utilisateurs crées avec succes');
    }

    #[Route('/creeruser', name: 'app_creeruser')]
    public function creeruser(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager)
    {
        $spreadsheet = IOFactory::load('fichier/Base de données application RH.xlsx');
        $sheet = $spreadsheet->getActiveSheet();

        // =========== Récupérer les données du tableau Excel =============
        $data = [];
        foreach ($sheet->getRowIterator() as $row) {
            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = $cell->getValue();
            }
            $data[] = $rowData;
        }

        // ================= Formater les données dans le format souhaité =============
        $formattedData = [];
        foreach ($data as $row) {
            $formattedData[] = [
                'username' => $row[0],
                'matricule' => $row[1]
            ];
        }

        $newFormattedData = [];
        foreach ($formattedData as $user) {

            $username = $user['username'];
            $modifiedUsername = strtoupper($username);
            $modifiedUsername = str_replace(['é', 'è', 'ê', 'ë'], 'E', $modifiedUsername);
            $user['username'] = $modifiedUsername;
            $newFormattedData[] = $user;
        }

        // ============ PARCOURIR TOUTES LES LIGNES DU TABLEAU =================

        foreach( $newFormattedData as $usera ) {

            $user = new User();
            $user->setUsername($usera['username']);
            $user->setRoles(['ROLE_ACTIF', 'ROLE_USER']);

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $usera['matricule']
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

        }

        return new Response('Utilisateurs crées avec succes');
    }
}
