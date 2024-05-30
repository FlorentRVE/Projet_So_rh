<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AttestationEmployeurControllerTest extends WebTestCase
{
    public function testPageAccess(): void
    {

        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'admin']);
        $client->loginUser($testUser);

        $client->request('GET', '/attestation_employeur');
        $this->assertResponseIsSuccessful();

    }

    public function testFormSuccess(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'admin']);

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/attestation_employeur');

        $form = $crawler->selectButton('submit')->form();

        $form['attestation_employeur[service]'] = "1";
        $form['attestation_employeur[email]'] = 'john.doe@example.com';
        $form['attestation_employeur[telephone]'] = '0256363636';
        $form['attestation_employeur[fonction]'] = 'John Doe';
        $form['attestation_employeur[motif]'] = 'Test';
        $form['attestation_employeur[recuperation]'] = 'Sur place';
        
        $client->submit($form);
        $this->assertEmailCount(1);

    }

    public function testFormError(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'admin']);

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/attestation_employeur');

        $form = $crawler->selectButton('submit')->form();

        $form['attestation_employeur[service]'] = "1";
        $form['attestation_employeur[email]'] = 'john.do';
        $form['attestation_employeur[telephone]'] = '0256363636';
        $form['attestation_employeur[fonction]'] = 'John Doe';
        $form['attestation_employeur[motif]'] = 'Test';
        $form['attestation_employeur[recuperation]'] = 'Sur place';

        $client->submit($form);
        $this->assertSelectorTextContains('li', 'L\'adresse email doit être au format valide.');
        $this->assertEmailCount(0);

    }

    public function testEmail(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'admin']);

        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/attestation_employeur');

        $form = $crawler->selectButton('submit')->form();

        $form['attestation_employeur[service]'] = "1";
        $form['attestation_employeur[email]'] = 'john.doe@example.com';
        $form['attestation_employeur[telephone]'] = '0256363636';
        $form['attestation_employeur[fonction]'] = 'John Doe';
        $form['attestation_employeur[motif]'] = 'Test';
        $form['attestation_employeur[recuperation]'] = 'Sur place';

        $client->submit($form);

        $this->assertEmailCount(1);

        $email = $this->getMailerMessage();

        $this->assertEmailHtmlBodyContains($email, 'Demande d&#039;attestation employeur');
        $this->assertEmailHtmlBodyContains($email, 'Nom/Prénom');
        $this->assertEmailHtmlBodyContains($email, 'Fonction');
        $this->assertEmailHtmlBodyContains($email, 'Email');
        $this->assertEmailHtmlBodyContains($email, 'Telephone');
        $this->assertEmailHtmlBodyContains($email, 'Motif');

    }
}
