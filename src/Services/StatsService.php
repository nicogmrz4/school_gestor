<?php

namespace App\Services;

use App\Dto\SubjectAttendanceDTO;
use App\Dto\SubjectAttendanceIntervalDTO;
use App\Repository\CourseRepository;
use App\Repository\SubjectRepository;

class StatsService
{
    public function __construct(
        private SubjectRepository $subjectRepository,
        private CourseRepository $courseRepository
    ) {}
    
    /**
     * @return SubjectAttendanceDTO[]
     */
    public function courseSubjectAttendancePerInterval(int $courseId, int $periodInterval = 1)
    {
        $course = $this->courseRepository
            ->find($courseId);
        $subjects = $course->getSubjects();
        $startDate = $course->getStartDate()->format('Y-m-d'); // All of course already has a start date on creation
        $finishedAt = $course->getFinishedAt();
        $finishedAt = $finishedAt ? $finishedAt->format('Y-m-d') : null; // finishedAt can be null if course is not finished yet

        $subjectsAttendance = [];

        foreach ($subjects as $key => $subject) {
            $subjectAttendances = $this->subjectRepository
                ->getSubjectAttendancePerMonthInterval($subject->getId(), $periodInterval, $startDate, $finishedAt);

            $subjectAttendanceIntervals = [];

            foreach ($subjectAttendances as $interval) {
                $subjectAttendanceIntervals[] = new SubjectAttendanceIntervalDTO(
                    $interval['attendance'],
                    $interval['classes'],
                    $interval['period_from'],
                    $interval['period_to']
                );
            }

            $subjectsAttendance[] = new SubjectAttendanceDTO(
                $subject,
                $subjectAttendanceIntervals
            );
        }

        return $subjectsAttendance;
    }
}
