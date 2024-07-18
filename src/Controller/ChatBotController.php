<?php

namespace App\Controller;

use App\Repository\BotCategorieRepository;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Web\WebDriver as Driver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ChatBotController extends AbstractController
{
    #[Route('/chatbot', name: 'app_chatbot_index')]
    public function index(BotCategorieRepository $botCategorieRepository)
    {
        $config = [
            // Your driver-specific configuration
            // "telegram" => [
            //    "token" => "TOKEN"
            // ]
        ];

        DriverManager::loadDriver(Driver::class);

        $botman = BotManFactory::create($config);
        $botCategorie = $botCategorieRepository->findAll();

        // Give the bot something to listen for.

        // ===============================
        
        foreach ($botCategorie as $categorie) {

            $botman->hears($categorie->getLabel(), function (BotMan $bot) use ($categorie) {

                $reply = 'Que voulez-vous savoir : <br> <br>';

                foreach ($categorie->getBotQuestions() as $question) {
                    $reply .= "<a href=\"#\" id=\"reponse\" onclick=\"reponse(this)\">" . $question->getQuestion() . "</a> <br> <br>";
                }

                $bot->reply($reply);

            });

            foreach ($categorie->getBotQuestions() as $question) {

                $botman->hears($question->getQuestion(), function (BotMan $bot) use ($question) {

                    $bot->reply($question->getReponse());
                });
            }
        }

        // =======================================

        $botman->fallback(function ($bot) use ($botCategorie) {
            $bot->reply('Choisissez une catégorie :');
            $reply = 'Votre question concerne <br> <br>';
            foreach ($botCategorie as $categorie) {
                $reply .= "<a href=\"#\" id=\"reponse\" onclick=\"reponse(this)\">" . $categorie->getLabel() . "</a> <br> <br>";
            }
            $bot->ask(
                $reply,
                function ($answer, $bot) {
                    $bot->reply($answer);
                }
            );
        });

        // Start listening
        $botman->listen();

        exit;
    }

    #[Route('/chatbotvue', name: 'app_chatbot_vue')]
    public function chatbot()
    {
        return $this->render('chat_bot/index.html.twig');
    }

    #[Route('/gestion_chatbot', name: 'app_chatbot_gestion')]
    public function chatbot_gestion()
    {
        return $this->render('chat_bot/gestion.html.twig');
    }
}
