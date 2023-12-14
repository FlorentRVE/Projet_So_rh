<?php

namespace App\Controller;

use App\Entity\Champs;
use App\Form\ChampsType;
use App\Repository\FormulaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/champs')]
class ChampsController extends AbstractController
{
    #[Route('/', name: 'app_champs_index', methods: ['GET'])]
    public function index(FormulaireRepository $formulaireRepository): Response
    {
        $data = $formulaireRepository->getChampsByFormulaire();

        return $this->render('champs/index.html.twig', [
            'data' => $data,
        ]);
    }

    #[Route('/new', name: 'app_champs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $champ = new Champs();
        $form = $this->createForm(ChampsType::class, $champ);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($champ);
            $entityManager->flush();

            $id = $champ->getFormulaire()->getId();

            return $this->redirectToRoute('app_champs_index', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('champs/new.html.twig', [
            'champ' => $champ,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_champs_show', methods: ['GET'])]
    public function show(Champs $champ): Response
    {
        return $this->render('champs/show.html.twig', [
            'champ' => $champ,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_champs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Champs $champ, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChampsType::class, $champ);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $id = $champ->getFormulaire()->getId();

            return $this->redirectToRoute('app_champs_index', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('champs/edit.html.twig', [
            'champ' => $champ,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_champs_delete', methods: ['POST'])]
    public function delete(Request $request, Champs $champ, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$champ->getId(), $request->request->get('_token'))) {
            $entityManager->remove($champ);
            $entityManager->flush();
        }
        $id = $champ->getFormulaire()->getId();

        return $this->redirectToRoute('app_champs_index', ['id' => $id], Response::HTTP_SEE_OTHER);
    }
}
