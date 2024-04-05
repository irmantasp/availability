<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\GroupFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class GroupFixtures extends Fixture implements DependentFixtureInterface
{
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

        $groupOwners = GroupFactory::faker()->randomElements($users, random_int(1, ((int) count($users) / 2)));
        $possibleGroupMembers = array_udiff(
            $users,
            $groupOwners,
            static function (User $first, User $second) {
                return $first->getId() <=> $second->getId();
            }
        );
        $maxGroupMembers = (int) (count($possibleGroupMembers) / 2);
        foreach ($groupOwners as $groupOwner) {
            $groupMembers = GroupFactory::faker()->randomElements($possibleGroupMembers, random_int(0, $maxGroupMembers));
            $groupMembers[] = $groupOwner;
            GroupFactory::createMany(
                GroupFactory::faker()->numberBetween(1, 7),
                [
                    'user' => $groupOwner,
                    'members' => $groupMembers,
                ]
            );
        }

        $manager->flush();
    }
}
