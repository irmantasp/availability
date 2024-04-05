<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AdminUserFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'admin-user';

    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(
        UserPasswordHasherInterface $userPasswordHasher
    ) {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $userAdmin = new User();

        $userAdmin
            ->setEmail('admin@example.com')
            ->setRoles(['ROLE_ADMIN']);

        $password = $this->userPasswordHasher->hashPassword($userAdmin, $userAdmin->getEmail());

        $userAdmin->setPassword($password);

        $manager->persist($userAdmin);
        $manager->flush();

        $this->addReference(self::ADMIN_USER_REFERENCE, $userAdmin);
    }
}
