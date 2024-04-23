<?php

namespace App\Services;

use App\Dto\SubjectAttendanceDTO;
use App\Dto\SubjectAttendanceIntervalDTO;
use App\Repository\SubjectClassRepository;
use App\Repository\SubjectRepository;
use DateTime;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class CourseCharts
{
    public function __construct(
        private SubjectRepository $subjectRepository,
        private ChartBuilderInterface $chartBuilder,
        private SubjectClassRepository $subjectClassRepository,
        private StatsService $statsService
    ) {
    }

    /**
     * @param SubjectAttendanceDTO[] $subjectsAttendanceDTO
     */
    public function generateSubjectsAttendancePerInterval($subjectsAttendanceDTO): Chart
    {
        $chartLabels = array_map(
            fn (SubjectAttendanceIntervalDTO $interval) =>
            sprintf(
                '%s - %s',
                DateTime::createFromFormat('Y-m-d', $interval->periodFrom)
                    ->format('d, M, Y'),
                DateTime::createFromFormat('Y-m-d', $interval->periodTo)
                    ->format('d, M, Y')
            ),
            $subjectsAttendanceDTO[0]->intervals
        );

        $datasets = [];

        foreach ($subjectsAttendanceDTO as $key => $_subjectAttendanceDTO) {
            $data = array_map(function(SubjectAttendanceIntervalDTO $interval) {
                return number_format($interval->attendance / $interval->classes, 2);
            }, $_subjectAttendanceDTO->intervals);

            $color = "rgb(" . rand(0, 255) . "," . rand(0, 255) . "," . rand(0, 255) . ")"; //TODO improve color randomization
            
            $datasets[] = [
                'label' => $_subjectAttendanceDTO->subject->getName(),
                'backgroundColor' => $color,
                'borderColor' => $color,
                'data' => $data
            ];
        }

        $chart = $this->chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'datasets' => $datasets,
            'labels' => $chartLabels
        ]);
        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 10
                ],
            ],
        ]);

        return $chart;
    }
}
