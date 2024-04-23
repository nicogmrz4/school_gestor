<?php

namespace App\Controller\Admin;

use App\Entity\ClassAttendance;
use App\Entity\SubjectClass;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class SubjectClassCrudController extends AbstractCrudController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
    }

    public static function getEntityFqcn(): string
    {
        return SubjectClass::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined();
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateField::new('date'),
            AssociationField::new('subject'),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityManager->persist($entityInstance);

        $students = $entityInstance->getSubject()
            ->getCourse()
            ->getStudents()
            ->toArray();

        foreach ($students as $key => $student) {
            $classAttendance = new ClassAttendance();
            $classAttendance->setSubjectClass($entityInstance);
            $classAttendance->setStudent($student);
            $entityManager->persist($classAttendance);
        }

        $entityManager->flush();
    }

    public function configureActions(Actions $actions): Actions
    {
        $attendanceControl = Action::new('attendanceControl')
            ->linkToUrl(function (SubjectClass $entity) {
                $classAttendanceCrudUrl = $this->adminUrlGenerator
                    ->unsetAll()
                    ->setController(ClassAttendanceCrudController::class)
                    ->set('subjectClassId', $entity->getId())
                    ->generateUrl();
                
                return $classAttendanceCrudUrl;
            });

        return $actions
            ->add(Crud::PAGE_INDEX, $attendanceControl)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE);
    }
}
