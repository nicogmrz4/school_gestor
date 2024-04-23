<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\ClassAttendanceFactory;
use App\Factory\CourseFactory;
use App\Factory\StudentFactory;
use App\Factory\SubjectClassFactory;
use App\Factory\SubjectFactory;
use App\Factory\UserFactory;
use DateInterval;
use DateTime;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $this->createAdminUser();

        $course = CourseFactory::createOne([
            'name' => 'Computer I',
            'students' => StudentFactory::createMany(15),
            'startDate' => DateTimeImmutable::createFromFormat('Y-m-d', '2023-03-13'),
        ]);

        $subjects = SubjectFactory::createMany(5, [
            'course' => $course
        ]);

        $courseStudents = $course->getStudents();

        foreach ($subjects as $key => $subject) {
            $subjectClasses = SubjectClassFactory::createSequence(
                function () use ($subject, $key) {
                    foreach (range(1, 32) as $week) {
                        $date = new DateTime('2023-03-13');
                        $date->add(DateInterval::createFromDateString(sprintf('%d week %d day', 1 * $week, $key))); // Use key to create a different day for each subject class
                        yield ['date' => $date, 'subject' => $subject];
                    }
                }
            );
            
            foreach ($subjectClasses as $key => $subjectClass) {
                foreach ($courseStudents as $key => $student) {
                    ClassAttendanceFactory::createOne([
                        'student' => $student,
                        'subjectClass' => $subjectClass
                    ]);
                }
            }
        }
    }

    private function createAdminUser()
    {
        UserFactory::createOne([
            'username' => 'admin',
            'password' => '$2y$13$Hz7GMPkLwK10KRzwNjVl3ukq8HAquLCgUJc9LCVZU0.inXoBVdjr2',
            'roles' => ['ROLE_ADMIN']
        ]);
    }
}
