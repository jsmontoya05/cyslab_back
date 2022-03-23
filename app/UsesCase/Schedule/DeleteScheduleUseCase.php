<?php

declare(strict_types=1);

namespace App\UsesCase\Schedule;

use App\Services\ScheduleService;

final class DeleteScheduleUseCase
{
    /** @var  ScheduleService */
    private ScheduleService $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function execute(String $labAccountName, String $labName, String $environmentSettingName, String $name)
    {   
  
       $response = $this->scheduleService->deleteSchedule($labAccountName, $labName, $environmentSettingName, $name);
        return $response;
    }
}
