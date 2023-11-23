<?php

namespace App\Controller;

use App\Entity\Champs;
use App\Entity\Formulaire;
use App\Form\FormulaireType;
use App\Repository\FormulaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/formulaire')]
class FormulaireController extends AbstractController
{
    #[Route('/', name: 'app_formulaire_index', methods: ['GET'])]
    public function index(FormulaireRepository $formulaireRepository): Response
    {
        return $this->render('formulaire/index.html.twig', [
            'formulaires' => $formulaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_formulaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $formulaire = new Formulaire();

        $defaut_champ = new Champs();
        $defaut_champ->setLabel('Champ par défaut');
        $defaut_champ->setCode('<p class="text-slate-50">Champ par défaut</p>');
        $formulaire->addChamp($defaut_champ);

        $form = $this->createForm(FormulaireType::class, $formulaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($defaut_champ);
            $entityManager->persist($formulaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_formulaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formulaire/new.html.twig', [
            'formulaire' => $formulaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formulaire_show', methods: ['GET'])]
    public function show(Formulaire $formulaire): Response
    {
        $champs = $formulaire->getChamps();

        return $this->render('formulaire/show.html.twig', [
            'formulaire' => $formulaire,
            'champs' => $champs
        ]);
    }

    #[Route('/{id}/edit', name: 'app_formulaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formulaire $formulaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FormulaireType::class, $formulaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_formulaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formulaire/edit.html.twig', [
            'formulaire' => $formulaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formulaire_delete', methods: ['POST'])]
    public function delete(Request $request, Formulaire $formulaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formulaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($formulaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_formulaire_index', [], Response::HTTP_SEE_OTHER);
    }
}
