<?php

namespace App\Controller;

use App\Services\SubjectAttendanceCalculatorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CourseAttendanceStatsController extends AbstractController
{
    public function __construct(
        private SubjectAttendanceCalculatorService $subjectAttendanceCalculatorService
    ) {}

    #[Route('/course/attendance/stats', name: 'app_course_attendance_stats')]
    public function index(Request $request): Response
    {
        $courseId = $request->get('courseId');
        $sort = $request->get('sort');
        $order = $request->get('order');
        $columns = [
            'id' => 'ID',
            'firstName' => 'First name',
            'lastName' => 'Last name',
            'presentAvg' => 'Present AVG'
        ];

        $result = $this->subjectAttendanceCalculatorService->calcCourseAttendancePerStudent($courseId);


        return $this->render('course_attendance_stats/index.html.twig', [
            'courseId' => $courseId,
            'data' => $result['data'],
            'columns' => $columns,
            "sort" => $sort,
            "order" => $order
        ]);
    }
}
