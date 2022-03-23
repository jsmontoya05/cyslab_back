<?php

declare(strict_types=1);

namespace App\UsesCase\Laboratory;

use App\UsesCase\EnviromentSettings\FindEnvironmentSettingsForLaboratoryUseCase;
use Illuminate\Support\Facades\Log;
final class FindProcessStatusLaboratoryUseCase
{
    private FindEnvironmentSettingsForLaboratoryUseCase $findEnvironmentSettingsForLaboratoryUseCase;

    public function __construct(FindEnvironmentSettingsForLaboratoryUseCase $findEnvironmentSettingsForLaboratoryUseCase)
    {
        $this->findEnvironmentSettingsForLaboratoryUseCase = $findEnvironmentSettingsForLaboratoryUseCase;
    }

    public function execute(String $labAccountName, String $labName,String $environmentSettingsName)
    {
        $environmentSettings = $this->findEnvironmentSettingsForLaboratoryUseCase->execute($labAccountName, $labName,$environmentSettingsName);
        Log::error(json_encode($environmentSettings));
        $response = (array)[
            'environmentSettings'                      => $environmentSettings,
            'publishingState'                          => $environmentSettings['properties']['publishingState'],
            'environmentSettingsPublishingState'       => $environmentSettings['properties']['publishingState']    == 'Published',
            "provisioningState"                        => $environmentSettings['properties']['provisioningState'],
            'environmentSettingsProvisioningState'     => $environmentSettings['properties']['provisioningState']  == 'Succeeded'
        ];
        Log::error(json_encode($response));
        return $response;
    }
}
