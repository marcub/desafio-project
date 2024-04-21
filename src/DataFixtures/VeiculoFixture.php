<?php

namespace App\DataFixtures;

use App\Factory\VeiculoFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VeiculoFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        VeiculoFactory::createMany(1000);
    }
}
