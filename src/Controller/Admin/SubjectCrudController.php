<?php

namespace App\Controller\Admin;

use App\Entity\Subject;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SubjectCrudController extends AbstractCrudController
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Subject::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
        ];

        $teacher = AssociationField::new('teacher')
            ->setFormTypeOption('query_builder', function (UserRepository $ur) {
                return $ur->createQueryBuilder('u')
                    ->andWhere('u.roles LIKE :role')
                    ->setParameter('role', sprintf('%s', '%TEACHER%'));
            });

        $fields[] = $teacher;

        $course = AssociationField::new('course');

        $fields[] = $course;

        return $fields;
    }

    public function configureActions(Actions $actions): Actions
    {
        $subjectAttendance = Action::new('subjectAttendance')
            ->linkToRoute(
                'app_subject_attendance_stats',
                fn (Subject $entity) => [
                    'subjectId' => $entity->getId()
                ]
            );

        return $actions
            ->add(Crud::PAGE_INDEX, $subjectAttendance);
    }
}
