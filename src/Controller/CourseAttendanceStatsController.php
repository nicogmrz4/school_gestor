<?php

namespace App\Controller;

use App\Form\SubjectsAttendancePerMonthFiltersType;
use App\Services\CourseCharts;
use App\Services\StatsService;
use App\Services\SubjectAttendanceCalculatorService;
use App\Vo\PeriodFilter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CourseAttendanceStatsController extends AbstractController
{
    public function __construct(
        private SubjectAttendanceCalculatorService $subjectAttendanceCalculatorService,
        private CourseCharts $courseCharts,
        private StatsService $statsService
    ) {
    }

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

    #[Route('/course/subjects/attendance/stats', name: 'app_course_subjects_attendance_stats')]
    public function SubjectsAttendanceStats(Request $request): Response
    {
        $courseId = $request->get('courseId');
        $periodFilter = new PeriodFilter($request->get('period'));
        $stats = $this->statsService
            ->courseSubjectAttendancePerInterval($courseId, $periodFilter->value);
        $chart = $this->courseCharts->generateSubjectsAttendancePerInterval($stats);
        $form = $this->createForm(SubjectsAttendancePerMonthFiltersType::class);
        $form->get('selectPeriod')->setData($periodFilter->value);

        return $this->render('course_attendance_stats/subjects.html.twig', [
            'chart' => $chart,
            'form' => $form,
            'stats' => $stats
        ]);
    }
}
