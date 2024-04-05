<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private const AMOUNT = 50;

    public function getDependencies(): array
    {
        return [
            AdminUserFixtures::class,
        ];
    }
    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(self::AMOUNT);

        $manager->flush();
    }
}
