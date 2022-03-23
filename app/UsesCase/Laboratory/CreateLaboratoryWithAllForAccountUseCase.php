<?php

declare(strict_types=1);

namespace App\UsesCase\Laboratory;

use App\UsesCase\Laboratory\CreateLaboratoryForAccountUseCase;
use App\UsesCase\EnviromentSettings\CreateEnviromentSettingsForLaboratoryUseCase;
use App\Jobs\PublishTemplateOfVirtualMachines;

final class CreateLaboratoryWithAllForAccountUseCase
{
    private CreateLaboratoryForAccountUseCase $createLaboratoryForAccountUseCase;
    private CreateEnviromentSettingsForLaboratoryUseCase $createEnviromentSettingsForLaboratoryUseCase;

    public function __construct(
        CreateLaboratoryForAccountUseCase $createLaboratoryForAccountUseCase,
        CreateEnviromentSettingsForLaboratoryUseCase $createEnviromentSettingsForLaboratoryUseCase
    )
    {
        $this->createLaboratoryForAccountUseCase            = $createLaboratoryForAccountUseCase;
        $this->createEnviromentSettingsForLaboratoryUseCase = $createEnviromentSettingsForLaboratoryUseCase;
    }

    public function execute(
        String $labAccountName,
        String $labName, 
        $maxUsersInLab,
        $usageQuota, 
        String $enviromentSettingsName, 
        String $template, 
        String $size,
        String $username,
        String $password)
    {
        $laboratory         = [];
        $enviromentSettings = [];
    
        $laboratory = $this->createLaboratoryForAccountUseCase->execute($labAccountName,$labName,$maxUsersInLab,$usageQuota);
      
        if (!isset($laboratory['content']['error'])) {
        
            $enviromentSettings = $this->createEnviromentSettingsForLaboratoryUseCase->execute(
                $labAccountName,
                $labName,// labName
                $enviromentSettingsName,// enviromentSettingsName
                $template, //resourceIdImageOfGallery
                $size, //virtualMachineSize,
                $username,
                $password
            );

            if (!isset($enviromentSettings['content']['error'])) {
                PublishTemplateOfVirtualMachines::dispatch([
                    "laboratoryName"         => $labName,
                    "enviromentSettingsName" => $enviromentSettingsName,
                    "labAccountName"         => $labAccountName
                    ])->delay(now()->addMinutes(20));
            }
        } 
        
        return [
            'laboratory'         => $laboratory,
            'enviromentSettings' => $enviromentSettings
        ];
    }
}
