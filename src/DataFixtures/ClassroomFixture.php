<?php

namespace App\DataFixtures;

use App\Entity\Classroom;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ClassroomFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $generator = Factory::create();

        for ($i = 0; $i < 21; $i++) {
            $classroom = new Classroom();
            $classroom->setName(sprintf('Classroom №%s', $i + 1));
            $classroom->setCreatedAt(date_create());
            $classroom->setIsActive($generator->boolean);
            $manager->persist($classroom);
        }

        $manager->flush();
    }
}