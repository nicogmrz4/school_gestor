<?php

namespace App\Repository;

use App\Entity\SubjectClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SubjectClass>
 *
 * @method SubjectClass|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubjectClass|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubjectClass[]    findAll()
 * @method SubjectClass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjectClassRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubjectClass::class);
    }

    //    /**
    //     * @return SubjetClass[] Returns an array of SubjetClass objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SubjetClass
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
