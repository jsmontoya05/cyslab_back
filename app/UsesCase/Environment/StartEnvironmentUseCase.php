<?php

declare(strict_types=1);

namespace App\UsesCase\Environment;

use App\Services\EnvironmentService;

final class StartEnvironmentUseCase {
    
    /** @var  EnvironmentService */
    private EnvironmentService $environmentService;

    public function __construct(EnvironmentService $environmentService){
        $this->environmentService = $environmentService;
    }

    public function execute(String $labAccountName,String $labName,String $environmentSettingName, String $environmentName){
        $this->environmentService->startEnvironment($labAccountName,$labName,$environmentSettingName,$environmentName);
    }

}