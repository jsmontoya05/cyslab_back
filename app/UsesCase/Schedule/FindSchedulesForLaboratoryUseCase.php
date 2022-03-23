<?php

declare(strict_types=1);

namespace App\UsesCase\Schedule;

use App\Services\ScheduleService;

final class FindSchedulesForLaboratoryUseCase
{
    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function execute(String $labAccountName,String $labName,String $environmentSettingName)
    {   
        return $this->scheduleService->obtainSchedules($labAccountName,$labName,$environmentSettingName);
    }
}
