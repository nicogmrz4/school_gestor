<?php

namespace App\Repository;

use App\Entity\SubjectClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
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

    public function totalPresentPerStudentBySubject(int $subjectId) 
    {
        return $this->createQueryBuilder('sc')
            ->select("sum(case when ca.status = 'present' then 1 else 0 end) as totalPresents")
            ->addSelect("st.id, st.firstName, st.lastName")
            ->join('sc.classAttendances', 'ca')
            ->join('sc.subject', 's')
            ->join('s.course', 'c')
            ->join('c.students', 'st')
            ->where('ca.student = st')
            ->andWhere('sc.subject = :subjectId')
            ->setParameter(':subjectId', $subjectId)
            ->groupBy('st.id')
            ->orderBy('totalPresents', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function totalSubjectClasses(int $subjectId)
    {
        return $this->createQueryBuilder('sc')
            ->select('count(sc.id) as totalClasses')
            ->where('sc.subject = :subjectId')
            ->setParameter('subjectId', $subjectId)
            ->getQuery()
            ->getResult(Query::HYDRATE_SINGLE_SCALAR);
    }
}
