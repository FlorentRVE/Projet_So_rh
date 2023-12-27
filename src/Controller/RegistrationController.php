<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/massuser', name: 'app_massuser')]
    public function massuser(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user_array = [
            [
                'username' => 'admin',
                'matricule' => 'adminadmin',
            ],
        ];

        foreach( $user_array as $usera ) {

            $user = new User();
            $user->setUsername($usera['username']);
            $user->setRoles(['ROLE_ACTIF', 'ROLE_ADMIN']);

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
