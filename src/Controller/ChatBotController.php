<?php

namespace App\Controller;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Web\WebDriver as Driver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChatBotController extends AbstractController
{
    #[Route('/chatbot', name: 'app_chatbot_index')]
    public function index()
    {
        $config = [
            // Your driver-specific configuration
            // "telegram" => [
            //    "token" => "TOKEN"
            // ]
        ];

        DriverManager::loadDriver(Driver::class);

        $botman = BotManFactory::create($config);

        // Give the bot something to listen for.

        // ============= CONGES ===================

        $botman->hears('Question sur les congés', function (BotMan $bot) {
            $bot->reply('Que voulez-vous savoir : <br> <br>
        <a href="#" id="reponse" onclick="reponse(this)">Quels sont les différents types de congés disponibles</a> <br> <br>
        <a href="#" id="reponse" onclick="reponse(this)">Comment faire une demande de congé</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Quelle est la durée des congés</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Sont-ils payés</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Quels sont les congés exceptionnels disponibles</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Quelle est la politique de l\'entreprise concernant les congés non pris ou les congés sabbatiques</a> <br> <br> 
        ');
        });

        $botman->hears('Quels sont les différents types de congés disponibles', function (BotMan $bot) {
            $bot->reply('Les différents types de congés disponibles sont les congés payés, les congés maladie, les congés maternité/paternité, les congés sans solde, les congés pour événements familiaux, etc. <br> <br>');
        });

        $botman->hears('Comment faire une demande de congé', function (BotMan $bot) {
            $bot->reply('Pour faire une demande de congé, veuillez suivre ces étapes : [insérer les étapes ici] <br> <br>');
        });

        $botman->hears('Quelle est la durée des congés', function (BotMan $bot) {
            $bot->reply('La durée des congés dépend du type de congé et des politiques de l\'entreprise. Les congés payés ont généralement une durée spécifiée dans la législation du travail. <br> <br>');
        });

        $botman->hears('Sont-ils payés', function (BotMan $bot) {
            $bot->reply('Certains congés, comme les congés payés, sont rémunérés, tandis que d\'autres, comme les congés sans solde, ne le sont pas. Veuillez vous référer aux politiques de l\'entreprise pour plus d\'informations. <br> <br>');
        });

        $botman->hears('Quels sont les congés exceptionnels disponibles', function (BotMan $bot) {
            $bot->reply('Les congés exceptionnels disponibles peuvent inclure les congés pour décès, les congés pour mariage, les congés pour déménagement, etc. Veuillez vérifier les politiques de l\'entreprise pour la liste complète. <br> <br>');
        });

        $botman->hears('Quelle est la politique de l\'entreprise concernant les congés non pris ou les congés sabbatiques', function (BotMan $bot) {
            $bot->reply('La politique de l\'entreprise concernant les congés non pris ou les congés sabbatiques peut varier. Il est recommandé de consulter le manuel de l\'employé ou de contacter le service des ressources humaines pour obtenir des informations détaillées. <br> <br>');
        });

        // ================== FORMATION ==================

        $botman->hears('Question sur la formation en entreprise', function (BotMan $bot) {
            $bot->reply('Que voulez-vous savoir : <br> <br>
        <a href="#" id="reponse" onclick="reponse(this)">Quels types de formation sont disponibles en entreprise</a> <br> <br>
        <a href="#" id="reponse" onclick="reponse(this)">Comment puis-je m\'inscrire à une formation en entreprise</a> <br> <br>
        <a href="#" id="reponse" onclick="reponse(this)">Y a-t-il des formations obligatoires pour tous les employés</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Comment puis-je proposer une nouvelle formation à l\'entreprise</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Quelles sont les politiques de remboursement des frais de formation</a> <br> <br>
        <a href="#" id="reponse" onclick="reponse(this)">Comment puis-je accéder aux ressources de formation en ligne de l\'entreprise</a> <br> <br> 
        ');
        });

        $botman->hears('Quels types de formation sont disponibles en entreprise', function (BotMan $bot) {
            $bot->reply('Les types de formation disponibles en entreprise peuvent inclure des formations en présentiel, des formations en ligne, des ateliers, des formations certifiées, etc. <br> <br>');
        });

        $botman->hears('Comment puis-je m\'inscrire à une formation en entreprise', function (BotMan $bot) {
            $bot->reply('Pour vous inscrire à une formation en entreprise, veuillez suivre ces étapes : [insérer les étapes ici] <br> <br>');
        });

        $botman->hears('Y a-t-il des formations obligatoires pour tous les employés', function (BotMan $bot) {
            $bot->reply('Oui, il peut y avoir des formations obligatoires pour tous les employés, telles que la formation à la sécurité, la formation sur la diversité, etc. <br> <br>');
        });

        $botman->hears('Comment puis-je proposer une nouvelle formation à l\'entreprise', function (BotMan $bot) {
            $bot->reply('Pour proposer une nouvelle formation à l\'entreprise, veuillez contacter le service des ressources humaines ou le département de la formation pour obtenir les instructions sur le processus de proposition. <br> <br>');
        });

        $botman->hears('Quelles sont les politiques de remboursement des frais de formation', function (BotMan $bot) {
            $bot->reply('Les politiques de remboursement des frais de formation peuvent varier selon l\'entreprise. Veuillez consulter le manuel de l\'employé ou contacter le service des ressources humaines pour obtenir des informations détaillées. <br> <br>');
        });

        $botman->hears('Comment puis-je accéder aux ressources de formation en ligne de l\'entreprise', function (BotMan $bot) {
            $bot->reply('Pour accéder aux ressources de formation en ligne de l\'entreprise, veuillez suivre ces étapes : [insérer les étapes ici] <br> <br>');
        });

        // ============== PAIE ====================

        $botman->hears('Question sur la paie en entreprise', function (BotMan $bot) {
            $bot->reply('Que voulez-vous savoir : <br> <br>
        <a href="#" id="reponse" onclick="reponse(this)">Comment puis-je consulter ma fiche de paie</a> <br> <br>
        <a href="#" id="reponse" onclick="reponse(this)">Quels sont les différents éléments inclus dans ma fiche de paie</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Comment sont calculés les impôts sur le salaire</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Quelle est la fréquence de versement des salaires</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Comment puis-je mettre à jour mes informations bancaires pour le versement du salaire</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Y a-t-il des avantages supplémentaires inclus dans la paie, tels que des primes ou des allocations</a> <br> <br>
        ');
        });

        $botman->hears('Comment puis-je consulter ma fiche de paie', function (BotMan $bot) {
            $bot->reply('Pour consulter votre fiche de paie, veuillez suivre ces étapes : [insérer les étapes ici] <br> <br>');
        });

        $botman->hears('Quels sont les différents éléments inclus dans ma fiche de paie', function (BotMan $bot) {
            $bot->reply('Les différents éléments inclus dans votre fiche de paie peuvent inclure le salaire de base, les primes, les retenues pour impôts, les allocations, etc. <br> <br>');
        });

        $botman->hears('Comment sont calculés les impôts sur le salaire', function (BotMan $bot) {
            $bot->reply('Les impôts sur le salaire sont calculés en fonction du barème d\'imposition en vigueur et des informations déclarées par l\'employé dans son formulaire de déclaration d\'impôt. <br> <br>');
        });

        $botman->hears('Quelle est la fréquence de versement des salaires', function (BotMan $bot) {
            $bot->reply('La fréquence de versement des salaires peut varier selon l\'entreprise, mais elle est souvent mensuelle, bi-mensuelle ou hebdomadaire. <br> <br>');
        });

        $botman->hears('Comment puis-je mettre à jour mes informations bancaires pour le versement du salaire', function (BotMan $bot) {
            $bot->reply('Pour mettre à jour vos informations bancaires pour le versement du salaire, veuillez contacter le service des ressources humaines pour obtenir les instructions sur le processus de mise à jour. <br> <br>');
        });

        $botman->hears('Y a-t-il des avantages supplémentaires inclus dans la paie, tels que des primes ou des allocations', function (BotMan $bot) {
            $bot->reply('Oui, il peut y avoir des avantages supplémentaires inclus dans la paie, tels que des primes, des allocations de transport, des avantages sociaux, etc. <br> <br>');
        });

        // ============= SITUATION DE LA FAMILLE ====================

        $botman->hears('Question sur la situation de famille', function (BotMan $bot) {
            $bot->reply('Que voulez-vous savoir : <br> <br>
        <a href="#" id="reponse" onclick="reponse(this)">Quelles sont les démarches à suivre pour déclarer un changement de situation familiale</a> <br> <br>
        <a href="#" id="reponse" onclick="reponse(this)">Quels sont les avantages liés à la situation de famille, tels que les congés familiaux ou les allocations familiales</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Comment mettre à jour mes informations de situation de famille dans le système de l\'entreprise</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Quelles sont les politiques de l\'entreprise en matière de congés parentaux ou de congés liés à la situation de famille</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Comment puis-je obtenir des informations sur les services de soutien familial offerts par l\'entreprise</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Y a-t-il des réductions d\'impôts ou des avantages fiscaux liés à la situation de famille</a> <br> <br> 
        ');
        });

        $botman->hears('Quelles sont les démarches à suivre pour déclarer un changement de situation familiale', function (BotMan $bot) {
            $bot->reply('Pour déclarer un changement de situation familiale, veuillez suivre ces étapes : [insérer les étapes ici] <br> <br>');
        });

        $botman->hears('Quels sont les avantages liés à la situation de famille, tels que les congés familiaux ou les allocations familiales', function (BotMan $bot) {
            $bot->reply('Les avantages liés à la situation de famille peuvent inclure des congés familiaux, des allocations familiales, des avantages fiscaux, etc. <br> <br>');
        });

        $botman->hears('Comment mettre à jour mes informations de situation de famille dans le système de l\'entreprise', function (BotMan $bot) {
            $bot->reply('Pour mettre à jour vos informations de situation de famille, veuillez suivre ces étapes : [insérer les étapes ici] <br> <br>');
        });

        $botman->hears('Quelles sont les politiques de l\'entreprise en matière de congés parentaux ou de congés liés à la situation de famille', function (BotMan $bot) {
            $bot->reply('Les politiques de l\'entreprise en matière de congés parentaux ou de congés liés à la situation de famille peuvent varier. Veuillez consulter le manuel de l\'employé ou contacter le service des ressources humaines pour obtenir des informations détaillées. <br> <br>');
        });

        $botman->hears('Comment puis-je obtenir des informations sur les services de soutien familial offerts par l\'entreprise', function (BotMan $bot) {
            $bot->reply('Pour obtenir des informations sur les services de soutien familial offerts par l\'entreprise, veuillez contacter le service des ressources humaines ou le département des avantages sociaux. <br> <br>');
        });

        $botman->hears('Y a-t-il des réductions d\'impôts ou des avantages fiscaux liés à la situation de famille', function (BotMan $bot) {
            $bot->reply('Oui, il peut y avoir des réductions d\'impôts ou des avantages fiscaux liés à la situation de famille, tels que des crédits d\'impôt pour enfants, des déductions pour frais de garde d\'enfants, etc. <br> <br>');
        });

        // ============== AVANTAGES SOCIAUX ==================

        $botman->hears('Question sur les avantages sociaux', function (BotMan $bot) {
            $bot->reply('Que voulez-vous savoir : <br> <br>
        <a href="#" id="reponse" onclick="reponse(this)">Quels sont les différents avantages sociaux offerts par l\'entreprise, tels que l\'assurance maladie, l\'assurance vie, ou les régimes de retraite</a> <br> <br>
        <a href="#" id="reponse" onclick="reponse(this)">Comment puis-je m\'inscrire aux différents programmes d\'avantages sociaux proposés par l\'entreprise</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Quelles sont les démarches à suivre pour signaler un problème ou une réclamation concernant mes avantages sociaux</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Quelles sont les politiques de l\'entreprise en matière de congés liés aux avantages sociaux, tels que les congés maladie ou les congés parentaux</a> <br> <br> 
        <a href="#" id="reponse" onclick="reponse(this)">Y a-t-il des ressources ou des services de soutien disponibles pour m\'aider à comprendre mes avantages sociaux et à prendre des décisions éclairées</a> <br> <br> 
        ');
        });

        $botman->hears('Quels sont les différents avantages sociaux offerts par l\'entreprise, tels que l\'assurance maladie, l\'assurance vie, ou les régimes de retraite', function (BotMan $bot) {
            $bot->reply('Les différents avantages sociaux offerts par l\'entreprise peuvent inclure l\'assurance maladie, l\'assurance vie, les régimes de retraite, les avantages liés à la santé mentale, etc. <br> <br>');
        });

        $botman->hears('Comment puis-je m\'inscrire aux différents programmes d\'avantages sociaux proposés par l\'entreprise', function (BotMan $bot) {
            $bot->reply('Pour vous inscrire aux différents programmes d\'avantages sociaux proposés par l\'entreprise, veuillez suivre ces étapes : [insérer les étapes ici] <br> <br>');
        });

        $botman->hears('Quelles sont les démarches à suivre pour signaler un problème ou une réclamation concernant mes avantages sociaux', function (BotMan $bot) {
            $bot->reply('Pour signaler un problème ou une réclamation concernant vos avantages sociaux, veuillez contacter le service des ressources humaines ou le fournisseur d\'avantages sociaux désigné par l\'entreprise. <br> <br>');
        });

        $botman->hears('Quelles sont les politiques de l\'entreprise en matière de congés liés aux avantages sociaux, tels que les congés maladie ou les congés parentaux', function (BotMan $bot) {
            $bot->reply('Les politiques de l\'entreprise en matière de congés liés aux avantages sociaux, tels que les congés maladie ou les congés parentaux, peuvent varier. Veuillez consulter le manuel de l\'employé ou contacter le service des ressources humaines pour obtenir des informations détaillées. <br> <br>');
        });

        $botman->hears('Y a-t-il des ressources ou des services de soutien disponibles pour m\'aider à comprendre mes avantages sociaux et à prendre des décisions éclairées', function (BotMan $bot) {
            $bot->reply('Oui, il peut y avoir des ressources ou des services de soutien disponibles pour vous aider à comprendre vos avantages sociaux et à prendre des décisions éclairées. Veuillez contacter le service des ressources humaines pour obtenir plus d\'informations. <br> <br>');
        });

        // =======================================

        $botman->fallback(function ($bot) {
            $bot->reply('Désolé, je ne comprends pas votre demande.');
            $bot->ask(
                'Comment puis-je vous aider ? <br> <br> <a href="#" id="reponse" onclick="reponse(this)">Question sur les congés</a> | <a href="#" id="reponse" onclick="reponse(this)">Question sur la formation en entreprise</a> | <a href="#" id="reponse" onclick="reponse(this)">Question sur la paie en entreprise</a> | <a href="#" id="reponse" onclick="reponse(this)">Question sur la situation de famille</a> | <a href="#" id="reponse" onclick="reponse(this)">Question sur les avantages sociaux</a>',
                function ($answer, $bot) {
                    $bot->reply($answer);
                }
            );
        });

        // Start listening
        $botman->listen();

        die();
    }

    #[Route('/chatbotvue', name: 'app_chatbot_vue')]
    public function chatbot()
    {
        return $this->render('chat_bot/index.html.twig');
    }
}
