<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Motorista;
use App\Factory\MotoristaFactory;

class MotoristaFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        MotoristaFactory::createMany(1000);
    }
}
