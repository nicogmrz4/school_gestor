<?php

namespace App\Controller;

use App\Services\SubjectAttendanceCalculatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubjectAttendanceStatsController extends AbstractController
{
    public function __construct(
        private SubjectAttendanceCalculatorService $subjectAttendanceCalculatorSvc
    )
    {
        
    }

    #[Route('/subject/attendance/stats', name: 'app_subject_attendance_stats')]
    public function index(Request $request): Response
    {
        $subjectId = $request->get('subjectId');
        $sort = $request->get('sort');
        $order = $request->get('order');
        $result = $this->subjectAttendanceCalculatorSvc->calcSubjectAttendancePerStudent($subjectId);
        $columns = [
            'id' => 'ID',
            'firstName' => 'First name',
            'lastName' => 'Last name',
            'presentAvg' => 'Present AVG'
        ];
        
        return $this->render('subject_attendance_stats/index.html.twig', [
            'subjectId' => $subjectId,
            'data' => $result['data'],
            'totalSubjectClasses' => $result['totalSubjectClasses'],
            'columns' => $columns,
            'subjectId' => $subjectId,
            "sort" => $sort,
            "order" => $order
        ]);
    }
}
