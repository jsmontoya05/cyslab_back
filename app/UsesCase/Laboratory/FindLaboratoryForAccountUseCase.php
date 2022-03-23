<?php

declare(strict_types=1);

namespace App\UsesCase\Laboratory;

use App\Services\LaboratoryService;

final class FindLaboratoryForAccountUseCase
{
    private LaboratoryService $laboratoryService;


    public function __construct(LaboratoryService $laboratoryService)
    {
        $this->laboratoryService = $laboratoryService;
    }

    public function execute(String $labAccountName,$labName)
    {
        $response = $this->laboratoryService->obtainLaboratory($labAccountName,$labName);
        return $response;
    }
}
