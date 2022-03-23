<?php

declare(strict_types=1);

namespace App\UsesCase\Laboratory;

use App\Services\LaboratoryService;

final class FindLaboratoriesForAccountUseCase
{
    public function __construct(LaboratoryService $laboratoryService)
    {
        $this->laboratoryService = $laboratoryService;
    }

    public function execute(String $labAccountName)
    {   
        $response = $this->laboratoryService->obtainLaboratories($labAccountName);
        return $response;
    }
}
