<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $user->setUsername('admin');
        $user->setPassword('adminadmin');
        $user->setRoles(['ROLE_ADMIN', 'ROLE_ACTIF', 'ROLE_USER']);

        $manager->persist($user);
        $manager->flush();
    }
}
