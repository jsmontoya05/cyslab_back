<?php

declare(strict_types=1);

namespace App\UsesCase\EnviromentSettings;

use App\Services\EnviromentSettingsService;
use Illuminate\Support\Facades\Log;

final class CreateEnviromentSettingsForLaboratoryUseCase
{
    private EnviromentSettingsService $enviromentSettingsService;

    public function __construct(EnviromentSettingsService $enviromentSettingsService)
    {
        $this->enviromentSettingsService = $enviromentSettingsService;
    }

    public function execute(
        String $labAccountName,
        String $laboratoryName, 
        String $enviromentSettingsName, 
        String $galleryImageResourceId, 
        String $size,
        String $userName = 'pruebasgraciasadios',
        String $password = '230dsaDd-3-.23')
    {
        $enviromentSettings = [
            'name'                       => $enviromentSettingsName,
            'galleryImageResourceId'     => $galleryImageResourceId,
            'size'                       => $size,
            'userName'                   => $userName,
            'password'                   => $password
        ];

        $response = $this->enviromentSettingsService->createEnviromentSettings(
            $labAccountName,
            $laboratoryName,
            $enviromentSettings
        );

        return $response;
    }
}
