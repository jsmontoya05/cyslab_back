<?php

declare(strict_types=1);

namespace App\UsesCase\Environment;

use App\Services\EnvironmentService;

final class DefineMaxUsersEnvironmentsUseCase
{
    public function __construct(EnvironmentService $environmentService)
    {
        $this->environmentService = $environmentService;
    }

    public function execute(String $labAccountName, String $labName, Int $numberUsers)
    {   
        $response = $this->environmentService->defineMaxUsers($labAccountName,$labName,$numberUsers);
        return $response;
    }
}
