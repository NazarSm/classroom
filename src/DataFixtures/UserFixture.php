<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Test');
        $user->setEmail('test@gmail.com');
        $user->setApiToken('123qweasdzxc');

        $manager->persist($user);

        $manager->flush();
    }
}