<?php

declare(strict_types=1);

namespace App\UsesCase;

use App\Services\LaboratoryService;
use App\Services\EnviromentSettingsService;
use Illuminate\Support\Facades\Log;

final class UpdateLaboratoryForAccountUseCase
{
    private LaboratoryService $laboratoryService;
    private EnviromentSettingsService $enviromentSettingsService;

    public function __construct(
        LaboratoryService $laboratoryService,
        EnviromentSettingsService $enviromentSettingsService)
    {
        $this->laboratoryService = $laboratoryService;
        $this->enviromentSettingsService = $enviromentSettingsService;
    }

    public function execute($data)
    {
        /* $response = $this->laboratoryService->createLaboratory($data);

          $responseEnviromentSettings = $this->enviromentSettingsService->createEnviromentSettings(
            $data['name'],
            [
                'name'=>'default',
                'galleryImageResourceId'=>$data['template'],
                'size'=>$data['size']
        ]);

        return $response; */
    }
}
