<?php

namespace App\Controller;

use App\Entity\BotCategorie;
use App\Form\BotCategorieType;
use App\Repository\BotCategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bot/categorie')]
class BotCategorieController extends AbstractController
{
    #[Route('/', name: 'app_bot_categorie_index', methods: ['GET'])]
    public function index(BotCategorieRepository $botCategorieRepository): Response
    {
        return $this->render('chat_bot/bot_categorie/index.html.twig', [
            'bot_categories' => $botCategorieRepository->findAll(),
        ]);
    }

    #[Route('/nouvelle', name: 'app_bot_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $botCategorie = new BotCategorie();
        $form = $this->createForm(BotCategorieType::class, $botCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($botCategorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_bot_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chat_bot/bot_categorie/new.html.twig', [
            'bot_categorie' => $botCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bot_categorie_show', methods: ['GET'])]
    public function show(BotCategorie $botCategorie): Response
    {
        return $this->render('chat_bot/bot_categorie/show.html.twig', [
            'bot_categorie' => $botCategorie,
        ]);
    }

    #[Route('/{id}/modifier', name: 'app_bot_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BotCategorie $botCategorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BotCategorieType::class, $botCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bot_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chat_bot/bot_categorie/edit.html.twig', [
            'bot_categorie' => $botCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bot_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, BotCategorie $botCategorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$botCategorie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($botCategorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bot_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
