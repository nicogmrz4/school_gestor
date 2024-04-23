<?php

namespace App\Repository;

use App\Entity\Subject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Subject>
 *
 * @method Subject|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subject|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subject[]    findAll()
 * @method Subject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subject::class);
    }

    public function getSubjectAttendancePerMonth(int $subjectId, string $startDate = null, string $endDate = null)
    {
        $em = $this->getEntityManager();
        $startDate = $startDate ?? date('Y-m-01', strtotime('-1 year'));
        $endDate = $endDate ?? date('Y-m-d');

        $sql =
            "WITH RECURSIVE periods (p_from, p_to) AS
            (
            SELECT 
                DATE(:startDate),
                LAST_DAY(:startDate)
            UNION ALL
            SELECT 
                p_from + INTERVAL 1 MONTH - INTERVAL DAYOFMONTH(p_from) - 1 DAY, 
                CASE
                    WHEN LAST_DAY(p_from + INTERVAL 1 MONTH)  > :endDate 
                    THEN :endDate
                    ELSE LAST_DAY(p_from + INTERVAL 1 MONTH)
                END
            FROM periods 
            WHERE p_to < :endDate
            )
        SELECT
            p_from as periodFrom,
            p_to as periodTo,
            COALESCE(COUNT(DISTINCT sc.id), 0) as totalClasses,
            COALESCE(SUM(case when ca.status = 'present' then 1 else 0 end), 0) as totalPresents
        FROM periods
        JOIN subject s 
            ON s.id = :subjectId
        LEFT JOIN subject_class sc 
            ON sc.subject_id = s.id 
            AND sc.date >= p_from 
            AND sc.date <= p_to 
        LEFT JOIN class_attendance ca 
            ON ca.subject_class_id = sc.id
        GROUP BY p_from, p_to;
        ";

        $stmt = $em->getConnection()->prepare($sql);
        $stmt->bindValue(':subjectId', $subjectId);
        $stmt->bindValue(':startDate', $startDate);
        $stmt->bindValue(':endDate', $endDate);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }

    public function getSubjectAttendancePerTrimester(int $subjectId, string $startDate = null, string $endDate = null)
    {
        $em = $this->getEntityManager();
        $startDate = $startDate ?? date('Y-m-01', strtotime('-1 year'));
        $endDate = $endDate ?? date('Y-m-d');

        $sql =
            "WITH RECURSIVE periods (p_from, p_to) AS
                (
                SELECT 
                    DATE(:startDate),
                    LAST_DAY(:startDate + INTERVAL 2 MONTH)
                UNION ALL
                SELECT 
                    p_from + INTERVAL 3 MONTH - INTERVAL DAYOFMONTH(p_from) - 1 DAY,
                    CASE 
                        WHEN LAST_DAY(p_to + INTERVAL 3 MONTH) > :endDate 
                        THEN :endDate
                        ELSE LAST_DAY(p_to + INTERVAL 3 MONTH)
                    END
                FROM periods 
                WHERE p_to < :endDate
                )
            SELECT
                p_from as periodFrom,
                p_to as periodTo,
                COALESCE(COUNT(DISTINCT sc.id), 0) as totalClasses,
                COALESCE(SUM(case when ca.status = 'present' then 1 else 0 end), 0) as totalPresents
            FROM periods
            JOIN subject s ON s.id = :subjectId
            LEFT JOIN subject_class sc 
                ON sc.subject_id = s.id 
                AND sc.date >= p_from 
                AND sc.date <= p_to
            LEFT JOIN class_attendance ca 
                ON ca.subject_class_id = sc.id
            GROUP BY periodFrom, periodTo;
            ";

        $stmt = $em->getConnection()->prepare($sql);
        $stmt->bindValue(':subjectId', $subjectId);
        $stmt->bindValue(':startDate', $startDate);
        $stmt->bindValue(':endDate', $endDate);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }    
    
    public function getSubjectAttendancePerMonthInterval(int $subjectId, int $interval, string $startDate = null, string $endDate = null)
    {
        $em = $this->getEntityManager();
        $startDate = $startDate ?? date('Y-m-01', strtotime('-1 year'));
        $endDate = $endDate ?? date('Y-m-d');

        $sql =
            "WITH RECURSIVE periods (p_from, p_to) AS
                (
                SELECT 
                    DATE(:startDate),
                    LAST_DAY(:startDate + INTERVAL (:interval - 1) MONTH)
                UNION ALL
                SELECT 
                    p_from + INTERVAL :interval MONTH - INTERVAL DAYOFMONTH(p_from) - 1 DAY,
                    CASE 
                        WHEN LAST_DAY(p_to + INTERVAL :interval MONTH) > :endDate 
                        THEN :endDate
                        ELSE LAST_DAY(p_to + INTERVAL :interval MONTH)
                    END
                FROM periods 
                WHERE p_to < :endDate
                )
            SELECT
                p_from as period_from,
                p_to as period_to,
                COALESCE(COUNT(DISTINCT sc.id), 0) as classes,
                COALESCE(SUM(case when ca.status = 'present' then 1 else 0 end), 0) as attendance
            FROM periods
            JOIN subject s ON s.id = :subjectId
            LEFT JOIN subject_class sc 
                ON sc.subject_id = s.id 
                AND sc.date >= p_from 
                AND sc.date <= p_to
            LEFT JOIN class_attendance ca 
                ON ca.subject_class_id = sc.id
            GROUP BY period_from, period_to;
            ";

        $stmt = $em->getConnection()->prepare($sql);
        $stmt->bindValue(':subjectId', $subjectId);
        $stmt->bindValue(':startDate', $startDate);
        $stmt->bindValue(':endDate', $endDate);
        $stmt->bindValue(':interval', $interval);
        $result = $stmt->executeQuery();

        return $result->fetchAllAssociative();
    }
}
