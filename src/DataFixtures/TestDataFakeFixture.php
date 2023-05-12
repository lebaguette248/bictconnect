<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TestDataFakeFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create("de_DE");

        for($user =0; $user <10; $user++)
        {
            $userEntity = new User();
            $userEntity->setName($this->faker->firstName);
            $userEntity->setUsername($this->faker->userName);
            $userEntity->setPassword($this->faker->password);
            $manager->persist($userEntity);

            $this->addReference("user" . $user, $userEntity);
        }

        $manager->flush();
    }
}
