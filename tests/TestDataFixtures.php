<?php

namespace App\TestDataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestDataFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername("Nicky");
        $user->setName("Niq");
        $user->setPassword("helloworld");
        $manager->persist($user);
        $manager->flush();
    }
}
