<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Vo\PeriodFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CourseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Course::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */

    public function configureActions(Actions $actions): Actions
    {
        $courseAttendance = Action::new('attendanceStats')
            ->linkToRoute('app_course_attendance_stats', fn (Course $entity) => [
                'courseId' => $entity->getId()
            ]);

        # create a new action called attendancePerSubject
        $attendancePerSubject = Action::new('attendancePerSubject')
            ->linkToRoute('app_course_subjects_attendance_stats', fn (Course $entity) => [
                'courseId' => $entity->getId(),
                'period' => PeriodFilter::MONTHLY
            ]);

        return $actions
            ->add(Crud::PAGE_INDEX, $attendancePerSubject)
            ->add(Crud::PAGE_INDEX, $courseAttendance);
    }
}
