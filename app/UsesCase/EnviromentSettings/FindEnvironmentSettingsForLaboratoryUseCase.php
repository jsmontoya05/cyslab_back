<?php

declare(strict_types=1);

namespace App\UsesCase\EnviromentSettings;

use App\Services\EnviromentSettingsService;

final class FindEnvironmentSettingsForLaboratoryUseCase
{
    private EnviromentSettingsService $enviromentSettingsService;

    public function __construct(EnviromentSettingsService $enviromentSettingsService)
    {
        $this->enviromentSettingsService = $enviromentSettingsService;
    }

    public function execute(String $labAccountName, String $laboratoryName, String $enviromentSettingsName)
    {
        $response = $this->enviromentSettingsService->obtainEnviromentSettings($labAccountName,$laboratoryName,$enviromentSettingsName);
        return $response;
    }
}
