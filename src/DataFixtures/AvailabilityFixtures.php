<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\AvailabilityFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class AvailabilityFixtures extends Fixture implements DependentFixtureInterface
{
    private const AMOUNT = 10;
    public function getDependencies(): array
    {
        return [
            AdminUserFixtures::class,
            UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $userRepository = $manager->getRepository(User::class);
        $users = $userRepository->findAll();
        $users = array_filter($users, static function (User $user) {
            return !in_array('ROLE_ADMIN', $user->getRoles());
        });

        foreach ($users as $user) {
            AvailabilityFactory::createMany(
                AvailabilityFactory::faker()->numberBetween(0, self::AMOUNT),
                [
                    'user' => $user,
                ]
            );
        }

        $manager->flush();
    }
}