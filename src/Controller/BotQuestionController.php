<?php

namespace App\Controller;

use App\Entity\BotQuestion;
use App\Form\BotQuestionType;
use App\Repository\BotQuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/bot/question')]
class BotQuestionController extends AbstractController
{
    #[Route('/', name: 'app_bot_question_index', methods: ['GET'])]
    public function index(BotQuestionRepository $botQuestionRepository): Response
    {
        return $this->render('chat_bot/bot_question/index.html.twig', [
            'bot_questions' => $botQuestionRepository->findAll(),
        ]);
    }

    #[Route('/nouvelle', name: 'app_bot_question_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $botQuestion = new BotQuestion();
        $form = $this->createForm(BotQuestionType::class, $botQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($botQuestion);
            $entityManager->flush();

            return $this->redirectToRoute('app_bot_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chat_bot/bot_question/new.html.twig', [
            'bot_question' => $botQuestion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bot_question_show', methods: ['GET'])]
    public function show(BotQuestion $botQuestion): Response
    {
        return $this->render('chat_bot/bot_question/show.html.twig', [
            'bot_question' => $botQuestion,
        ]);
    }

    #[Route('/{id}/modifier', name: 'app_bot_question_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BotQuestion $botQuestion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BotQuestionType::class, $botQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_bot_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chat_bot/bot_question/edit.html.twig', [
            'bot_question' => $botQuestion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bot_question_delete', methods: ['POST'])]
    public function delete(Request $request, BotQuestion $botQuestion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$botQuestion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($botQuestion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_bot_question_index', [], Response::HTTP_SEE_OTHER);
    }
}
