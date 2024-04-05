<?php

namespace App\DataFixtures;

use App\Entity\Availability;
use App\Entity\Group;
use App\Factory\EventFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            AdminUserFixtures::class,
            UserFixtures::class,
            GroupFixtures::class,
            AvailabilityFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $groupRepository = $manager->getRepository(Group::class);
        $availabilityRepository = $manager->getRepository(Availability::class);

        $groups = $groupRepository->findAll();

        foreach ($groups as $group) {
            $members = $group->getMembers()->toArray();
            $groupAvailabilities = [];
            foreach ($members as $member) {
                $memberAvailabilities = $availabilityRepository->findBy(['user' => $member]);
                foreach ($memberAvailabilities as $memberAvailability) {
                    $groupAvailabilities[] = $memberAvailability;
                }
            }

            usort($groupAvailabilities, static function (Availability $first, Availability $second) {
                $firstArray = [$first->getYear(), $first->getMonth(), count($first->getDays())];
                $secondArray = [$second->getYear(), $second->getMonth(), count($second->getDays())];

                return $firstArray <=> $secondArray;
            });

            $availableGroupDays = [];
            foreach ($groupAvailabilities as $memberAvailability) {
                if (empty($memberAvailability->getDays())) {
                    continue;
                }

                $days = $memberAvailability->getDays();
                foreach ($days as $day) {
                    $dateString = sprintf(
                        '%d-%d-%d',
                        $memberAvailability->getYear(),
                        $memberAvailability->getMonth(),
                        $day
                    );
                    $date = \DateTime::createFromFormat('Y-m-d', $dateString);
                    $availableGroupDays[$date->format('Y-m-d')] = $date;
                }
            }
            $current = count($availableGroupDays);
            $max = $current > 100 ? 100 : (int) ($current / 2);
            $min = 0;
            $randomGroupDays = EventFactory::faker()->randomElements($availableGroupDays, random_int($min, $max));
            foreach ($randomGroupDays as $randomGroupDay) {
                EventFactory::createOne([
                    'user' => $group->getUser(),
                    'userGroup' => $group,
                    'date' => $randomGroupDay,
                ]);
            }

            $manager->flush();
        }

        $manager->flush();
    }
}
