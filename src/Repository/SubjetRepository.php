<?php

namespace App\Repository;

use App\Entity\Subjet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Subjet>
 *
 * @method Subjet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subjet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subjet[]    findAll()
 * @method Subjet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subjet::class);
    }

    //    /**
    //     * @return Subjet[] Returns an array of Subjet objects
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

    //    public function findOneBySomeField($value): ?Subjet
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
