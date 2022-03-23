<?php

declare(strict_types=1);

namespace App\UsesCase\Laboratory;

use App\Services\LaboratoryService;
use App\Services\EnviromentSettingsService;
use Illuminate\Support\Facades\Log;

final class CreateLaboratoryForAccountUseCase
{
    private LaboratoryService $laboratoryService;

    public function __construct(LaboratoryService $laboratoryService) {
        $this->laboratoryService = $laboratoryService;
    }

    public function execute($labAccountName,$labName,$maxUsersInLab,$usageQuota)
    {   
        $response = $this->laboratoryService->createLaboratory($labAccountName,$labName,$maxUsersInLab,$usageQuota);
        return $response;
    }
}
