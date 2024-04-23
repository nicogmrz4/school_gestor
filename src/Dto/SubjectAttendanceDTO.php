<?php

namespace App\Dto;

use App\Entity\Subject;

class SubjectAttendanceDTO
{
    /**
     * @param \App\Dto\AttendanceIntervalDTO[] $intervals
     */
    public function __construct(
        public Subject $subject,
        public $intervals
    ) {}
    
    public function getTotalClasses(): int
    {
        return array_reduce(
            $this->intervals,
            fn(int $total, SubjectAttendanceIntervalDTO $interval) => $total + $interval->classes,
            0
        );
    }

    public function getAttendanceAvg(): float
    {
        $avg = array_reduce(
            $this->intervals,
            fn(float $total, SubjectAttendanceIntervalDTO $interval) => $total + $interval->attendance,
            0
        ) / $this->getTotalClasses();

        return number_format($avg, 2);
    }
}