<?php

namespace App\Controller\Admin;

use App\Entity\ClassAttendance;
use App\Utils\ClassAttendanceStatus;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class ClassAttendanceCrudController extends AbstractCrudController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
    }

    public static function getEntityFqcn(): string
    {
        return ClassAttendance::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setSearchFields(null)
            ->showEntityActionsInlined();
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('student.firstName', 'First name')->onlyOnIndex(),
            TextField::new('student.lastName', 'Last name')->onlyOnIndex(),
        ];
        
        $statusField = TextField::new('status')
            ->setTemplatePath('admin/fields/status.html.twig')
            ->setEmptyData('to confirm')
            ->onlyOnIndex();

        $fields[] = $statusField;

        return $fields;
    }

    public function configureActions(Actions $actions): Actions
    {
        $confirmPresent = Action::new('present')
        ->linkToCrudAction('confirmPresent');
        $confirmAbsent = Action::new('absent')
            ->addCssClass('text-danger')
            ->linkToCrudAction('confirmAbsent');

        return $actions
            ->add(Crud::PAGE_INDEX, $confirmPresent)
            ->add(Crud::PAGE_INDEX, $confirmAbsent)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE);
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $subjectClassId = $searchDto->getRequest()->get('subjectClassId');
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        return $queryBuilder
            ->where('entity.subjectClass = :subjectClassId')
            ->setParameter('subjectClassId', $subjectClassId);
    }

    public function confirmPresent(AdminContext $context, EntityManagerInterface $em)
    {
        $classAttendance = $context->getEntity()->getInstance();
        $classAttendance->setStatus(ClassAttendanceStatus::PRESENT);

        $this->persistEntity($em, $classAttendance);

        $subjectClassId = $classAttendance->getSubjectClass()->getId();
        $url = $this->getCurrentURLWithSubjectClassId($subjectClassId);

        return $this->redirect($url);
    }

    public function confirmAbsent(AdminContext $context, EntityManagerInterface $em)
    {
        $classAttendance = $context->getEntity()->getInstance();
        $classAttendance->setStatus(ClassAttendanceStatus::ABSENT);

        $this->persistEntity($em, $classAttendance);

        $subjectClassId = $classAttendance->getSubjectClass()->getId();
        $url = $this->getCurrentURLWithSubjectClassId($subjectClassId);

        return $this->redirect($url);
    }

    private function getCurrentURLWithSubjectClassId(int $subjectClassId): string
    {
        return $this->adminUrlGenerator->setController(ClassAttendanceCrudController::class)
            ->set('subjectClassId', $subjectClassId)
            ->setAction(Action::INDEX)
            ->generateUrl();
    }
}
