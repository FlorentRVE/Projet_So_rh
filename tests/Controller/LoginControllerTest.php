<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLoginSuccess(): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneBy(['username' => 'admin']);
        $client->loginUser($testUser);

        $client->request('GET', '/accueil');
        $this->assertResponseIsSuccessful();

    }

    public function testAccessNonLogged(): void
    {
        $client = static::createClient();
        $client->request('GET', '/accueil');
        $this->assertResponseRedirects();
    }

    public function testLogout(): void
    {
        $client = static::createClient();
        $client->request('GET', '/logout');
        $this->assertResponseRedirects();
    }
}
