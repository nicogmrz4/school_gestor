<?php

namespace App\Repository;

use App\Entity\ClassAttendance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClassAttendance>
 *
 * @method ClassAttendance|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassAttendance|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassAttendance[]    findAll()
 * @method ClassAttendance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassAttendanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassAttendance::class);
    }

    //    /**
    //     * @return ClassAttendance[] Returns an array of ClassAttendance objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ClassAttendance
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
