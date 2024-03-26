<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\CourseFactory;
use App\Factory\StudentFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        $this->createAdminUser();

        CourseFactory::createOne([
            'name' => 'Computer I',
            'students' => StudentFactory::createMany(15)
        ]);
        CourseFactory::createOne([
            'name' => 'Computer II',
            'students' => StudentFactory::createMany(15)
        ]);
        CourseFactory::createOne([
            'name' => 'Computer III',
            'students' => StudentFactory::createMany(15)
        ]);
    }

    private function createAdminUser() {
        UserFactory::createOne([
            'username' => 'admin',
            'password' => '$2y$13$Hz7GMPkLwK10KRzwNjVl3ukq8HAquLCgUJc9LCVZU0.inXoBVdjr2',
            'roles' => ['ROLE_ADMIN']
        ]);
    }
}
