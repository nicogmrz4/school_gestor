<?php

namespace App\Controller\Admin;

use App\Entity\Subjet;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SubjetCrudController extends AbstractCrudController
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Subjet::class;
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
}
