<?php

declare(strict_types=1);

namespace App\UsesCase\Environment;

use App\Services\EnvironmentService;

final class DeleteEnvirometsUseCase
{
    public function __construct(EnvironmentService $environmentService)
    {
        $this->environmentService = $environmentService;
    }

    public function execute(String $labAccountName, String $labName, String $environmentSettingName, String $environmentName)
    {   
        $response = $this->environmentService->deleteEnvironment($labAccountName,$labName,$environmentSettingName,$environmentName);
        return $response;
    }
}
