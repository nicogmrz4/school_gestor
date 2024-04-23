<?php

namespace App\Dto;

class SubjectAttendanceIntervalDTO
{
    public function __construct(
        readonly public int $attendance,
        readonly public int $classes,
        readonly public string $periodFrom,
        readonly public string $periodTo
    ) {}
}