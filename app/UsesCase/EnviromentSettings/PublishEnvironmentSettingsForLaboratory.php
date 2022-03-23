<?php

declare(strict_types=1);

namespace App\UsesCase\EnviromentSettings;

use App\Services\EnviromentSettingsService;

final class PublishEnvironmentSettingsForLaboratory
{
    private EnviromentSettingsService $enviromentSettingsService;

    public function __construct(EnviromentSettingsService $enviromentSettingsService)
    {
        $this->enviromentSettingsService = $enviromentSettingsService;
    }

    public function execute(String $labAccountName, String $laboratoryName, String $enviromentSettingsName)
    {   
        $response = $this->enviromentSettingsService->publishEnviromentSetting($labAccountName, $laboratoryName,$enviromentSettingsName);
        return $response;
    }
}
