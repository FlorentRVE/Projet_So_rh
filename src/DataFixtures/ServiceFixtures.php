<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $service = new Service();
        $service->setLabel('ServiceTest');
        $service->setEmailResponsable('gQq2n@example.com');
        $service->setEmailSecretariat('gQq2n@example.com');

        $manager->persist($service);
        $manager->flush();
    }
}
