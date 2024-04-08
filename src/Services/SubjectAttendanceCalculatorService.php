<?php

namespace App\Services;

use App\Repository\SubjectClassRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

class SubjectAttendanceCalculatorService
{
    public function __construct(
        private EntityManagerInterface $em,
        private SubjectClassRepository $subjectClassRepository,
    ) {
    }

    public function calcSubjectAttendancePerStudent($subjectId)
    {
        $totalPresentPerStudent = $this->subjectClassRepository
            ->totalPresentPerStudentBySubject($subjectId);
        
        $totalSubjectClass = $this->subjectClassRepository
            ->totalSubjectClasses($subjectId);

        $studentPresentAVG = array_map(function($st) use($totalSubjectClass) {
            $st['presentAvg'] = $st['totalPresents'] / $totalSubjectClass * 100;
            return $st;
        }, $totalPresentPerStudent);

        return [
            'data' => $studentPresentAVG,
            'totalSubjectClasses' => $totalSubjectClass
        ];
    }
}
