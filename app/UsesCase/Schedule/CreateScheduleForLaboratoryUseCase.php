<?php

declare(strict_types=1);

namespace App\UsesCase\Schedule;

use App\Services\ScheduleService;

final class CreateScheduleForLaboratoryUseCase
{
    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function execute(
        String $labAccountName,
        String $labName,
        String $environmentSettingName,
        String $name,
        String $start,
        String $end,
        String $notes,
        String $timeZoneId
    ){   
        $response = $this->scheduleService->createSchedule(
            $labAccountName,
            $labName,
            $environmentSettingName,
            $name,
            $start,
            $end,
            $notes,
            $timeZoneId);
        return $response;
    }
}
